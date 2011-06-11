
function TalentCalculator(options) {

    // Variables
    var self = this;
    TalentCalculator.instances[options.id] = self;

    // Options
    var data;
    var calculatorMode = false;

    // Mode-based
    var pointsPerTier;
    var basePoints;
    var extraPoints;
    var totalPoints;

    // State
    var pointsSpent = 0;
    var processingBuild = false;
    var locked;
    var overviewPaneVisible = true;
    var dataLoaded = false;

    // Helper
    var allTalents = {};
    var allSpells = {};

    // DOM nodes
    var $talentCalc;
    var $chooseText;
    var $info;
    var $pointsSpent;
    var $pointsSpentValue;
    var $requiredLevel;
    var $requiredLevelValue;
    var $pointsLeft;
    var $pointsLeftValue;
    var $export;
    var $exportLink;
    var $reset;
    var $calcMode;
    var $fansiteLink;
    var $restore;
    var $toggleOverviewPane;

    // Constants
    var NUM_TREES = 3

    // Constructor
    init();

    // Public functions
    self.receiveData = function(d) {

        data = d.talentData.talentTrees;

        initData();
        initHtml();
        lock();

        overviewPaneVisible = (options.calculatorMode && !options.build); // Initial state

        if(options.build) {
            processBuild(options.build);
        }

        updateAllTrees();

        dataLoaded = true;

        if(options.callback) {
            eval(options.callback + '();');
        }
    };

    self.setBuild = function(build) {

        options.build = build;

        if(dataLoaded) {
            processBuild(build);
            lock();
            updateAllTrees();
        }
    };

    // Private functions
    function init() {

        calculatorMode = options.calculatorMode;

        initModeVariables();

        var url = Core.baseUrl + '/tool/talents/class/' + options.classId + '?jsonp=TalentCalculator.instances.' + options.id + '.receiveData';

        if($.browser.msie) {
            url += '&foo' + (+new Date);
        }

        $.getScript(url);
    }

    function initModeVariables() {

        pointsPerTier = 5;
        setPoints(51, 0);
    }

    function initData() {

        for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {

            var tree    = data[treeNo];
            var talents = tree.talents;

            tree.points = 0;
            tree.treeNo = treeNo;

            $.each(talents, function(idx) {

                this.points     = 0;
                this.tree       = data[treeNo];
                this.talentNo   = idx;
                this.treeNo     = treeNo;
                this.max        = this.ranks.length;
                this.dependants = [];

                allTalents[this.id] = this;
            });

            // 2nd pass once allTalents is initialized
            $.each(talents, function() {

                if(this.req) {
                    this.req = allTalents[this.req]; // Convert talent IDs to direct references
                    this.req.dependants.push(this);
                }
            });
        }
    }

    function initHtml() {

        $talentCalc = $('#talentcalc-' + options.id);

        // Talent trees
        var $treeWrappers = $talentCalc.children('div.talentcalc-tree-wrapper');
        for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {

            var tree = data[treeNo];

            var $treeWrapper = $($treeWrappers.get(treeNo));


            var $treeHeader   = $treeWrapper.children('div.talentcalc-tree-header');
            var $points       = $treeHeader.children('span.points');
            var $tree         = $treeWrapper.children('div.talentcalc-tree');
            var $treeOverview = $treeWrapper.children('div.talentcalc-tree-overview');
            var $cellsWrapper = $tree.children('div.talentcalc-cells-wrapper');
            var $cells        = $cellsWrapper.children('div');

            tree.$treeWrapper  = $treeWrapper;
            tree.$treeHeader   = $treeHeader;
            tree.$points       = $points;
            tree.$tree         = $tree;

            $cellsWrapper.delegate('a.interact', 'mouseover',   iconMouseOver);
            $cellsWrapper.delegate('a.interact', 'mouseout',    iconMouseOut);
            $cellsWrapper.delegate('a.interact', 'mousedown',   iconMouseDown);
            $cellsWrapper.delegate('a.interact', 'contextmenu', iconContextMenu);

            $cells.each(function() {

                var talent = getTalentFromCell(this);
                var $cell = $(this);

                talent.$cell     = $cell;
                talent.$icon     = $cell.children('span.icon');
                talent.$points   = $cell.children('span.points').children('span.value');
                talent.$interact = $cell.children('a.interact');

                if(talent.req) {
                    talent.$arrow = $cell.children('span.arrow');
                }
            });
        }

        var $bottom = $talentCalc.children('div.talentcalc-bottom')

        // Info
        $info = $bottom.children('div.talentcalc-info');
        $pointsSpent        = $info.children('div.pointsspent');
        $pointsSpentValue   = $pointsSpent.children('span.value');
        $requiredLevel      = $info.children('div.requiredlevel');
        $requiredLevelValue = $requiredLevel.children('span.value');
        $pointsLeft         = $info.children('div.pointsleft');
        $pointsLeftValue    = $pointsLeft.children('span.value');
        $reset              = $info.children('div.reset');
        $export             = $info.children('div.export');
        $exportLink         = $export.children('a');
        $calcMode           = $info.children('div.calcmode');
        $restore            = $info.children('div.restore');
        $fansiteLink        = $info.children('div.third-party');

        $reset.children('a').click(reset);
        $calcMode.children('a').click(enterCalculatorMode).mouseover(calcModeMouseOver);
        $restore.children('a').click(exitCalculatorMode);

        // Buttons
        var $buttons = $bottom.children('div.talentcalc-buttons');
        $toggleOverviewPane = $buttons.find('button');

        $toggleOverviewPane.click(toggleOverviewPane);
    }

    function processBuild(build) {

        processingBuild = true;

        resetAllTrees();

        // Remove any bonus points
        setPoints(null, 0);

        if(build.match(/^\d+/)) {
            processLongBuild(build);
        }

        processingBuild = false;

        // Set specialization based on points spent
        if(pointsSpent > 0) {
            var maxTreePoints = 0;
            var maxTreeNo = -1;
            for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {
                var tree = data[treeNo];
                if(tree.points > maxTreePoints) {
                    maxTreePoints = tree.points;
                    maxTreeNo = treeNo;
                }
            }
        }

    }

    function processLongBuild(build) {

        var pos = 0;

        for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {

            var talents = data[treeNo].talents;

            $.each(talents, function() {

                var talent = this;

                if(pos >= build.length)
                    return;

                var points = parseInt(build.charAt(pos));
                if(points > 0) {

                    addPointsToTalent(talent, points);
                }

                ++pos;
            });
        }
    }

    function lock() {
        locked = true;
        $talentCalc.addClass('talentcalc-locked');
    }

    function unlock() {
        locked = false;
        $talentCalc.removeClass('talentcalc-locked');
    }

    function toggleLock() {
        if(locked) {
            unlock();
        }
        else {
            lock();
        }
        updateAllTrees();
    };

    function updateAllTrees() {

        for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {
            var tree = data[treeNo];
            updateTree(tree);
        };

        updateInfo();

        if(calculatorMode) {
            $info.show();

            for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {
                var tree = data[treeNo];

                if(calculatorMode) {
                    tree.$treeHeader.css('visibility', 'hidden');
                    //tree.$button.show();
                }
            }
        }
    }

    function updateTree(tree) {

        tree.$points.text(tree.points);

        $.each(tree.talents, function() {
            this.enabled = doesTalentValidate(this);

            if(!this.enabled && this.points) {
                this.points = 0;
            }

            this.visible = true;

            updateTalentDisplay(this);
        });

    }

    function updateInfo() {

        // Info
        $pointsSpentValue.children('span').text(function(treeNo) {
            return data[treeNo].points;
        });
        $requiredLevelValue.text(getRequiredLevel());
        $pointsLeftValue.text(totalPoints - pointsSpent);

        // TODO: Export build to talent calculator
        //$exportLink.attr('href', ...);
    }

    function resetAllTrees() {

        for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {
            var tree = data[treeNo];
            resetTree(tree);
        };

    }

    function resetTree(tree) {
        pointsSpent -= tree.points;
        tree.points = 0;
        $.each(tree.talents, function() {
            this.points = 0;
        });
    }

    function reset() {
        resetAllTrees();
        updateAllTrees();
    }

    function setOverviewPane(visibility) {
        overviewPaneVisible = visibility;
        updateOverviewPane();
    }

    function toggleOverviewPane() {
        overviewPaneVisible = !overviewPaneVisible;
        updateOverviewPane();
    }

    function updateOverviewPane() {
        for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {
            var tree = data[treeNo];

            if(overviewPaneVisible) {
                tree.$treeOverview.show();
            } else {
                tree.$treeOverview.hide();
            }
        }

        $toggleOverviewPane.find('span span').text(overviewPaneVisible ? MsgTalentCalculator.buttons.overviewPane.hide : MsgTalentCalculator.buttons.overviewPane.show);
    }

    function doesTalentValidate(talent)
    {
        // Enough points spent in tree?
        if(talent.tree.points < getReqPointsInTree(talent)) {
            return false;
        }

        // Check required talent (if any)
        if(talent.req && talent.req.points < talent.req.max) {
            return false;
        }
        // Talent specialization
        if(!processingBuild) {
            if(talent.tree.locked) {
                return false;
            }
        }

        return true;
    }

    function updateTalentDisplay(talent) {

        var active = talent.enabled;
        if((locked || pointsSpent >= totalPoints) && talent.points == 0)
            active = false;

        talent.$cell.removeClass('talent-partial talent-full talent-arrow');

        talent.$icon.css('background-image', active ? 'url(' + Wow.Icon.getUrl(talent.icon, 36) + ')' : 'url(http://static.mmo-champion.com/db/img/icons/greyscale/' + talent.icon + '.png)');
        if(!active)
        {
            talent.$icon.css('background-size', '40px 40px');
            talent.$icon.css('background-position', 'center');
        }
        if(active) {

            if(talent.points < talent.max) {
                talent.$cell.addClass('talent-partial');
            } else {
                talent.$cell.addClass('talent-full');
            }

            if(talent.req)
                talent.$cell.addClass('talent-arrow');

        } else {


        }

        if(talent.visible) {
            talent.$cell.show();
        } else {
            talent.$cell.hide();
        }

        talent.$points.text(talent.points);
    }

    function addPointsToTalent(talent, points) {

        var pointsLeft = totalPoints - pointsSpent;

        if(
            pointsLeft == 0 ||
            points <= 0 ||
            talent.points >= talent.max // Talent already maxed out
        )
            return false;

        if(points > pointsLeft) { // Not enough points to spend
            points = pointsLeft;
        }

        if(talent.points + points >= talent.max) // Cap at maximum rank
            points = (talent.max - talent.points);

        if(!processingBuild) { // Additional validation is disabled while processing a talent build
            if(!talent.enabled)
                return false;
        }

        talent.points      += points;
        talent.tree.points += points;
        pointsSpent        += points;

        return true;
    }

    function removePointFromTalent(talent) {

        if(talent.points <= 0) // Already empty
            return false;

        if(specializationPoints && specialization != null && specialization == talent.tree.treeNo) {
            // Don't allow unspecializing if there are still points in the other trees
            var pointsSpentInMainTree = data[specialization].points;
            if(pointsSpentInMainTree == specializationPoints && pointsSpent > pointsSpentInMainTree) {
                return false;
            }
        }

        // Check talents on deeper tiers to see if removing a point would break them
        var brokenTalent = false;
        $.each(talent.tree.talents, function() {
            if(this.points > 0 && this.y > talent.y) {
                if(!testTalentAfterRemoval(this)) {
                    brokenTalent = true;
                    return false;
                }
            }
        });
        if(brokenTalent) {
            return false;
        }

        // All talents that require the current one must be empty
        var dependencyFound = false;
        $.each(talent.dependants, function() {
            if(this.points > 0) {
                dependencyFound = true;
                return false;
            }
        });
        if(dependencyFound) {
            return false;
        }

        talent.points      -= 1;
        talent.tree.points -= 1;
        pointsSpent        -= 1;

        return true;
    }

    function testTalentAfterRemoval(talent) {

        var reqPointsInTree = getReqPointsInTree(talent);

        var pointsInPreviousTiers = 0;
        $.each(talent.tree.talents, function() {
            if(this.y < talent.y) {
                pointsInPreviousTiers += this.points;
            }
        });

        return (pointsInPreviousTiers - 1) >= reqPointsInTree;;
    }

    function showTalentTooltip(talent) {

        var $tooltip = $('<ul/>');

        // Name
        $('<li/>').append($('<h3/>').text(talent.name)).appendTo($tooltip);

        // Rank
        $('<li/>').text(Core.msg(MsgTalentCalculator.talents.tooltip.rank, talent.points, talent.max)).appendTo($tooltip);

        // Warnings
        var enabled = (talent.enabled && !locked);
        if(!enabled) {

            if(talent.tree.locked) {
                $('<li/>', { "class": 'color-tooltip-red', text: Core.msg(MsgTalentCalculator.talents.tooltip.primaryTree, specializationPoints) }).appendTo($tooltip);
            }

            var reqPointsInTree = getReqPointsInTree(talent);
            if(talent.tree.points < reqPointsInTree) {
                $('<li/>', { "class": 'color-tooltip-red', text: Core.msg(MsgTalentCalculator.talents.tooltip.reqTree, reqPointsInTree, talent.tree.name) }).appendTo($tooltip);
            }

            if(talent.req && talent.req.points < talent.req.max) {
                $('<li/>', { "class": 'color-tooltip-red', text: Core.msg(MsgTalentCalculator.talents.tooltip.reqTalent, talent.req.max, talent.req.name) }).appendTo($tooltip);
            }
        }

        var currentRank = talent.ranks[Math.max(0, talent.points - 1)];

        appendSpellDescription($tooltip, currentRank);

        // Next rank
        if(!locked && talent.points > 0 && talent.points < talent.max) {
            $('<li/>').text(MsgTalentCalculator.talents.tooltip.nextRank).prepend($('<br/>')).appendTo($tooltip);
            $('<li/>', { "class": 'color-tooltip-yellow', text: talent.ranks[talent.points].description }).appendTo($tooltip);
        }

        // Interactivity
        if(enabled) {
            if(talent.points < talent.max) {
                $('<li/>', { "class": 'color-tooltip-green', text: MsgTalentCalculator.talents.tooltip.click }).appendTo($tooltip);
            } else {
                $('<li/>', { "class": 'color-tooltip-red', text: MsgTalentCalculator.talents.tooltip.rightClick }).appendTo($tooltip);
            }

        }

        Tooltip.show(talent.$interact, $tooltip);
    }

    function appendSpellDescription($tooltip, spell) {

        // Cost + Range
        if(spell.cost || spell.range) {
            var $line = $('<li/>');
            if(spell.range) {
                if(spell.cost) {
                    $('<span/>', { "class": 'float-right', text: spell.range }).appendTo($line);
                } else {
                    $line.text(spell.range);
                }
            }
            if(spell.cost) {
                $line.append(spell.cost);
            }
            $line.appendTo($tooltip);
        }

        // Cast time + Cooldown
        if(spell.castTime || spell.cooldown) {
            var $line = $('<li/>');
            if(spell.cooldown) {
                if(spell.castTime) {
                    $('<span/>', { "class": 'float-right', text: spell.cooldown }).appendTo($line);
                } else {
                    $line.text(spell.cooldown);
                }
            }
            if(spell.castTime) {
                $line.append(spell.castTime);
            }
            $line.appendTo($tooltip);
        }

        // "Requires ..." line
        if(spell.requires) {
            $('<li/>').text(spell.requires).appendTo($tooltip);
        }

        // Description
        $('<li/>', { 'class': 'color-tooltip-yellow', text: spell.description }).appendTo($tooltip);
    }

    function getRequiredLevel() {
        if(!pointsSpent)
            return '-';

        var reqLevel = 9;
        var points = pointsSpent;

        // First 2 points = every 1 level
        var part = Math.min(2, points);
        if(part > 0) {
            reqLevel += part;
            points -= part;
        }

        // Next 35 points = every 2 levels
        part = Math.min(35, points);
        if(part > 0) {
            reqLevel += part * 2;
            points -= part;
        }

        // Last 4 points = every 1 level
        part = Math.min(5, points);
        if(part > 0) {
            reqLevel += part;
            points -= part;
        }

        return reqLevel;
    }

    function showSingleTree(no) {
        singleTreeNo = no;

        for(var treeNo = 0; treeNo < NUM_TREES; ++treeNo) {
            var $treeWrapper = data[treeNo].$treeWrapper;
            if(treeNo == no) {
                $treeWrapper.show();
            } else {
                $treeWrapper.hide();
            }
        }

        $talentCalc.show();
    }

    function enterCalculatorMode() {

        calculatorMode = true;
        unlock();
        updateAllTrees();

        $pointsSpent.show();
        $requiredLevel.show();
        $pointsLeft.show();

        $reset.show();
        $calcMode.hide();
        $restore.show();
        $fansiteLink.hide();

        if(specializationPoints && pointsSpent == 0) {
            setSpecialization(-1);
        }
    }

    function exitCalculatorMode() {

        calculatorMode = false;
        if(options.build) {
            processBuild(options.build);
        }
        lock();
        updateAllTrees();

        $pointsSpent.hide();
        $requiredLevel.hide();
        $pointsLeft.hide();
        $reset.hide();
        $calcMode.show();
        $restore.hide();
        $fansiteLink.show();
    }

    function iconMouseOver() {

        var talent = getTalentFromCell(this);
        showTalentTooltip(talent);
    }

    function iconMouseOut() {
        Tooltip.hide();
    }

    function iconMouseDown(event) {

        if(locked) {
            return false;
        }

        var talent = getTalentFromCell(this);
        var added, removed;

        if(event.which == 3) { // Right click
            removed = removePointFromTalent(talent);
        } else { // Left click
            added = addPointsToTalent(talent, 1);
        }

        if(!added && !removed) { // Not changed
            return false;
        }

        var updateAll = false;

        if(specializationPoints && specialization != null) {

            var pointsSpentInMainTree = data[specialization].points;

            if(added) {
                if(pointsSpentInMainTree == specializationPoints) { // Fully specialized
                    updateAll = true;
                }
            }

            if(removed) {
                if(pointsSpentInMainTree == (specializationPoints - 1)) { // No longer fully specialized
                    updateAll = true;
                }
            }
        }

        if(added && pointsSpent == totalPoints) // All points have been spent
            updateAll = true;
        if(removed && pointsSpent == totalPoints - 1) // No longer have all points spent
            updateAll = true;

        if(updateAll) {
            updateAllTrees();
        } else {
            updateTree(talent.tree);
            updateInfo();
        }

        showTalentTooltip(talent);

        return false; // Disable text selection and dragging
    }

    function iconContextMenu() {
        return false;
    }

    function calcModeMouseOver() {

        var $tooltip = $('<ul/>');

        // Title
        $('<li/>').append($('<h3/>', { text: MsgTalentCalculator.info.calcMode.tooltip.title })).appendTo($tooltip);

        // Description
        $('<li/>').addClass('color-tooltip-yellow').text(MsgTalentCalculator.info.calcMode.tooltip.description).appendTo($tooltip);

        Tooltip.show(this, $tooltip);
    }

    // Utilities
    function setPoints(base, extra) {

        if(base != null)
            basePoints = base;

        if(extra != null)
            extraPoints = extra;

        totalPoints = basePoints + extraPoints;
    }

    function getTalentFromCell(cell) {

        var $cell = $(cell);
        if($cell.hasClass('interact')) {
            $cell = $cell.parent();
        }

        var id = $cell.attr('data-id');

        return allTalents[id];
    }

    function getReqPointsInTree(talent) {
        return talent.y * pointsPerTier; // Number of points required in the tree to have this talent
    }

}

TalentCalculator.instances = {};
