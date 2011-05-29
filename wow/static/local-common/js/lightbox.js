/**
 *
 * @copyright  2010, Blizzard Entertainment, Inc
 * @class      Lightbox
 *
 * @requires   Core
 */

var Lightbox = {
    timeout:        0,
    initialized:    false,
    contents:       [], //list of images or videos
    currentIndex:   0, //used for paging if content.length > 1
    contentType:    "image",
    DEFAULT_WIDTH:  480,
    DEFAULT_HEIGHT: 360,
    /**
     * Initializes lightbox and caches relevant DOM elements
     */
    init: function() {
        //init blackout first (adds to DOM)
        Blackout.initialize();

        //build lightbox elements (adds to DOM)
        Lightbox.build();

        Lightbox.initialized = true;
    },
    /**
     * Store content data for use later
     *
     * @param object content - array of images or videos
     * @param string contentType - type of content being show in the ligthbox, either "image" or "video"
     */
     storeContentData: function(content, contentType) {
         if (!Lightbox.initialized)
             Lightbox.init();
		 
        //store image list for paging
        Lightbox.contents = content;

        Lightbox.contentType = contentType;

        //store current index
        Lightbox.currentIndex = 0;

        //disable/enable paging
        Lightbox.controls.toggleClass("no-paging", (content.length < 2));
    },
    /**
     * Loads image into lightbox, adds paging if necessary
     *
     * @param array images - array of objects containing title (optional), src, and path (optional) of image to view.
     *  Example:
     *      [{ title: "Image title",
     *        src:    "http://us.media.blizzard.com/sc2/media/screenshots/protoss_archon_002-large.jpg",
     *        path:   "/sc2/en/media/screenshots/?view#/protoss_archon_002" (omitting the path property will cause the gallery-view icon to hide)
     *      }]
     *
     */
    loadImage: function(images, dontStore) {
         if (!Lightbox.initialized)
             Lightbox.init();

         //store data
		 if (!dontStore)
			Lightbox.storeContentData(images, "image");

		var index = (typeof images == 'number') ? images : 0;

         //show loading anim and start image fetch
         if (Lightbox.contents[index].src != "") {

             Lightbox.setFrameDimensions(Lightbox.DEFAULT_WIDTH, Lightbox.DEFAULT_HEIGHT);

             Lightbox.content
                 .removeAttr("style")
                 .addClass("loading")
                 .removeClass("lightbox-error")
                 .html("");

             Lightbox.show();
             Lightbox.setImage(Lightbox.preloadImage(Lightbox.contents[index]));
         } else {
             Lightbox.error();
         }
    },
    /**
     * Checks image until its loaded then sets as background image
     */
    setImage: function(loadingImage) {

            if (Core.isIE("6")) {
                if (Lightbox.controls.hasClass("no-paging") && Lightbox.controls.hasClass("no-gallery")) {
                    Lightbox.controls.addClass("no-controls").removeClass("no-paging no-gallery");
                }
            }

        if (loadingImage.complete) {

            //set as background image
            Lightbox.emptyContent();

            Lightbox.setFrameDimensions(loadingImage.width, loadingImage.height);
            Lightbox.content.html(loadingImage);
            Lightbox.checkGalleryLinkDisplay(!(Lightbox.contents[Lightbox.currentIndex].path));
        } else {
            Lightbox.timeout = window.setTimeout( function () { Lightbox.setImage(loadingImage) }, 100);
        }
    },
    /**
     * Loads a video or set of videos with paging in the lightbox
     *
     * @param arrray videos - array of video data
     *
     *  Example:
     *      [{  title:       "Video Title Text", //optional
     *          width:       890,
     *          height:      500,
     *          flvPath:     '/what-is-sc2/what-is-sc2.flv',
     *          path:        '/sc2/en/media/videos#/what-is-sc2' //optional
     *          showRating:  true, //optional, defaults to true
     *          cachePlayer: false //optional, defaults to false
     *      }];
     */
    loadVideo: function(videos) {

         if (!Lightbox.initialized)
             Lightbox.init();

         //store data
         Lightbox.storeContentData(videos, "video");

         //set first video
         Lightbox.setVideo(videos[0]);
    },
    /**
     * Sets video in lightbox
     */
    setVideo: function(video) {
        var currentFlashVars = {
            flvpath:   Flash.videoBase + video.flvPath,
            flvwidth:  video.width,
            flvheight: video.height
        };

        //add rating values
        if (!video.showRating || false) {
            currentFlashVars = $.extend(Flash.defaultVideoFlashVars, currentFlashVars);
        }

        //generate no cache string if needed
        if (video.cachePlayer || false) {
            var noCache = new Date();
            noCache = "?nocache=" + noCache.getTime();
        }

        //create a target for the video
        Lightbox.emptyContent();
        $("<div id='flash-target' />").appendTo(Lightbox.content);


        swfobject.embedSWF(Flash.videoPlayer + (noCache || ""), "flash-target", video.width, video.height,
                "9", Flash.expressInstall, currentFlashVars, Flash.defaultVideoParams);

        Lightbox.setFrameDimensions(video.width, video.height);
        Lightbox.show();
    },
    /**
     * View image in the media gallery
     */
    viewInGallery: function() {
        //hide tooltip to prevent artifacts
        if (Tooltip.initialized)
            Tooltip.wrapper.hide();

        Core.goTo(Lightbox.contents[Lightbox.currentIndex].path);

        return false;
    },
    /**
     * Dynamically sets border widths/heights based on dimensions so style integrity is maintained
     */
    setFrameDimensions: function(width, height) {

        if (width == 0 || height == 0) {
            Lightbox.error();
        } else {

            Lightbox.container
                .css({
                    top:    Page.scroll.top + "px",
                    width:  width + "px",
                    height: height + "px"
                });

            Lightbox.borderTop.width(width - 10 + "px");
            Lightbox.borderbottom.width(width  - 12 + "px");
            Lightbox.borderRight.height(height - 9 + "px");
            Lightbox.borderLeft.height(height - 9 + "px");
        }
    },
    /**
     * Toggles class on controls depending on if there is a link to the media gallery
     *
     * @param object content
     */
    checkGalleryLinkDisplay: function(hasPath) {
        Lightbox.controls.toggleClass("no-gallery", hasPath);
    },
    /**
     * Starts image preload
     */
    preloadImage: function(loadingImage) {
        var tempImage = new Image();
        tempImage.src = loadingImage.src;

        return tempImage;
    },
    show: function() {
        Blackout.show( function() { Lightbox.container[0].style.display = "block" },  Lightbox.close);
    },
    /**
     * Hides the lightbox
     */
    close: function() {
        clearTimeout(Lightbox.timeout);

        Blackout.hide(Lightbox.container.hide());

        //unload swf if needed
        if (Lightbox.contentType == "video") {
            swfobject.removeSWF("flash-target");
        }

        //hide tooltip to prevent artifacts
        if (Tooltip.initialized)
            Tooltip.wrapper.hide();
    },
    /**
     * Clears the content/classes of the viewer, putting it back into a fresh state
     */
    emptyContent: function() {
        Lightbox.content
            .removeAttr("style")
            .removeClass("loading lightbox-error")
            .empty();
    },
    /**
     * Shows lightbox in error state
     */
    error: function() {

        Lightbox.emptyContent();

        Lightbox.setFrameDimensions(Lightbox.DEFAULT_WIDTH, Lightbox.DEFAULT_HEIGHT);

        Lightbox.content
            .addClass("lightbox-error")
            .html("Error loading content.");

        Lightbox.show();
    },
    /**
     * Builds lightbox elements on demand so they aren't in DOM until we need them
     */
    build: function() {

        Lightbox.anchor =     $('<div id="lightbox-anchor" />');
        Lightbox.container =  $('<div id="lightbox-container" />').appendTo(Lightbox.anchor);
        Lightbox.content =    $('<div id="lightbox-content" />').appendTo(Lightbox.container).click(Lightbox.next);

        //ui-element link element template
        var uiElementLink = $("<a />").addClass("ui-element").attr("href", "javascript:;");

        //build controls
        Lightbox.controls = $('<div class="control-wrapper" />');
        Lightbox.controls
            .append(
                $('<div class="lightbox-controls ui-element" />')
                    //previous
                    .append(uiElementLink.clone().addClass("previous").click(Lightbox.previous))
                    //next
                    .append(uiElementLink.clone().addClass("next").click(Lightbox.next))
                    //gallery view
                    .append(uiElementLink.clone().addClass("gallery-view").click(Lightbox.viewInGallery)
                            .mouseover(function() {
                                Tooltip.show(this, Msg.ui.viewInGallery);
                                Tooltip.wrapper.css("z-index", "9007");
                            })
                            .mouseout(function() {
                                Tooltip.wrapper.css("z-index", "1000")
                            }))
            );

        //create borders before appending (need to access borders later to resize
        var border = $("<div />").addClass("border");
        Lightbox.borderTop    = border.clone().attr("id", "lb-border-top");
        Lightbox.borderRight  = border.clone().attr("id", "lb-border-right");
        Lightbox.borderbottom = border.clone().attr("id", "lb-border-bottom");
        Lightbox.borderLeft   = border.clone().attr("id", "lb-border-left");

        //plain corner element to clone
        var corner = $("<div />").addClass("corner");

        //append everything
        Lightbox.container
            //add corners
            .append(corner.clone().addClass("corner-top-left"))
            .append(corner.clone().addClass("corner-top-right"))
            .append(corner.clone().addClass("corner-bottom-left"))
            .append(corner.clone().addClass("corner-bottom-right"))
            //add borders
            .append(Lightbox.borderTop)
            .append(Lightbox.borderRight)
            .append(Lightbox.borderbottom)
            .append(Lightbox.borderLeft)
            //paging controls
            .append(Lightbox.controls)
            //close button
            .append(uiElementLink.clone().addClass("lightbox-close").click(Lightbox.close));

        //append to body at end to avoid any redraws
        Lightbox.anchor.appendTo("body");

    },
    /**
     * Gets the next image
     */
    next: function() {
        var totalContent = Lightbox.contents.length;

        if (totalContent > 1) {
            //increment index
            Lightbox.currentIndex++;

            //wrap back to 0
            if (Lightbox.currentIndex >= totalContent) {
                Lightbox.currentIndex = 0;
            }

            if (Lightbox.contentType == "image") {
                Lightbox.setImage(Lightbox.preloadImage(Lightbox.contents[Lightbox.currentIndex]));
            } else if (Lightbox.contentType == "video") {
                Lightbox.setVideo(Lightbox.contents[Lightbox.currentIndex]);
            }
        }
    },
    /**
     * Gets the previous image
     */
    previous: function() {
        var totalContent = Lightbox.contents.length;

        if (totalContent > 1) {
            //decrement
            Lightbox.currentIndex--;

            if (Lightbox.currentIndex < 0) {
                Lightbox.currentIndex = Lightbox.contents.length -1;
            }

            if (Lightbox.contentType == "image") {
                Lightbox.setImage(Lightbox.preloadImage(Lightbox.contents[Lightbox.currentIndex]));
            } else if (Lightbox.contentType == "video") {
                Lightbox.setVideo(Lightbox.contents[Lightbox.currentIndex]);
            }
        }
    }
};
