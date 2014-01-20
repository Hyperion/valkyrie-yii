<?php $progress = $model->raidProgression; ?>
<div id="summary-raid" class="summary-raid">
    <h3 class="category">Raid Progression</h3>

    <div class="profile-box-full">
        <div class="summary-raid-wrapper">
            <div id="summary-raid-wrapper-table" class="summary-raid-wrapper-table">
                <table cellspacing="0">
                    <tbody>
                        <tr class="icons">
                            <td></td>
                                <td class="mc expansion-0" data-raid="mc">
                                    <div class="icon">
                                        <div>MC</div>
                                    </div>
                                </td>
                                <td class="spacer"><div></div></td>
                                <td class="ony expansion-0" data-raid="ony">
                                    <div class="icon">
                                        <div>Ony</div>
                                    </div>
                                </td>
                                <td class="spacer"><div></div></td>
                                <td class="bwl expansion-0" data-raid="bwl">
                                    <div class="icon">
                                        <div>BWL</div>
                                    </div>
                                </td>
                                <td class="spacer"><div></div></td>
                                <td class="zg expansion-0" data-raid="zg">
                                    <div class="icon">
                                        <div>ZG</div>
                                    </div>
                                </td>
                            <td class="spacer-edge"><div></div></td>
                        </tr>
                        <tr class="normal">
                            <td></td>
                            <td data-raid="mc" class="status status-<?= $progress['mc']['status'] ?>"><div></div></td>
                            <td></td>
                            <td data-raid="ony" class="status status-<?= $progress['ony']['status'] ?>"><div></div></td>
                            <td></td>
                            <td data-raid="bwl" class="status status-<?= $progress['bwl']['status'] ?>"><div></div></td>
                            <td></td>
                            <td data-raid="zg" class="status status-<?= $progress['zg']['status'] ?>"><div></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <span class="clear"><!-- --></span>
        </div>

        <div class="summary-raid-legend">
            <span class="completed">Completed</span>
            <span class="in-progress">In progress</span>
        </div>

        <script type="text/javascript">
            //<![CDATA[
            $(document).ready(function() {
                new Summary.RaidProgression(
                    { nTrivialRaids: 0, nOptimalRaids: 3, nChallengingRaids: 0 },
                    {
                        mc: {
                            name: "Molten Core",
                            playerLevel: 60,
                            nPlayers: 40,
                            location: "Blackrock Mountain",
                            expansion: 0,
                            heroicMode: false,
                            normalEncounters: [
                                { name: "Lucifron",                 nKills: <?= $progress['mc'][0] ?> },
                                { name: "Magmadar",                 nKills: <?= $progress['mc'][1] ?> },
                                { name: "Gehennas",                 nKills: <?= $progress['mc'][2] ?> },
                                { name: "Garr",                     nKills: <?= $progress['mc'][3] ?> },
                                { name: "Baron Geddon",             nKills: <?= $progress['mc'][4] ?> },
                                { name: "Shazzrah",                 nKills: <?= $progress['mc'][5] ?> },
                                { name: "Sulfuron Harbinger",       nKills: <?= $progress['mc'][6] ?> },
                                { name: "Golemagg the Incinerator", nKills: <?= $progress['mc'][7] ?> },
                                { name: "Majordomo Executus",       nKills: <?= $progress['mc'][8] ?> },
                                { name: "Ragnaros",                 nKills: <?= $progress['mc'][9] ?> }
                            ]
                        },
                        ony: {
                            name: "Onyxia\'s Lair",
                            playerLevel: 60,
                            nPlayers: 40,
                            location: "Dustwallow Marsh",
                            expansion: 0,
                            heroicMode: false,
                            normalEncounters: [
                                { name: "Onyxia", nKills: <?= $progress['ony'][0] ?> }
                            ]
                        },
                        bwl: {
                            name: "Blackwing Lair",
                            playerLevel: 60,
                            nPlayers: 40,
                            location: "Blackrock Mountain",
                            expansion: 0,
                            heroicMode: false,
                            normalEncounters: [
                                { name: "Razorgore the Untamed",   nKills: <?= $progress['bwl'][0] ?> },
                                { name: "Vaelastrasz the Corrupt", nKills: <?= $progress['bwl'][1] ?> },
                                { name: "Broodlord Lashlayer",     nKills: <?= $progress['bwl'][2] ?> },
                                { name: "Firemaw",                 nKills: <?= $progress['bwl'][3] ?> },
                                { name: "Ebonroc",                 nKills: <?= $progress['bwl'][4] ?> },
                                { name: "Flamegor",                nKills: <?= $progress['bwl'][5] ?> },
                                { name: "Chromaggus",              nKills: <?= $progress['bwl'][6] ?> },
                                { name: "Nefarian",                nKills: <?= $progress['bwl'][7] ?> }
                            ]
                        },
                        zg: {
                            name: "Zul'Gurub",
                            playerLevel: 60,
                            nPlayers: 20,
                            location: "Stranglethorn Vale",
                            expansion: 0,
                            heroicMode: false,
                            normalEncounters: [
                                { name: "High Priestess Jeklik", nKills: <?= $progress['zg'][0] ?> },
                                { name: "High Priest Venoxis",   nKills: <?= $progress['zg'][1] ?> },
                                { name: "High Priestess Mar'li", nKills: <?= $progress['zg'][2] ?> },
                                { name: "High Priest Thekal",    nKills: <?= $progress['zg'][3] ?> },
                                { name: "High Priestess Arlokk", nKills: <?= $progress['zg'][4] ?> },
                                { name: "Hakkar the Soulflayer", nKills: <?= $progress['zg'][5] ?> },
                                { name: "Bloodlord Mandokir",    nKills: <?= $progress['zg'][6] ?> },
                                { name: "Jin'do the Hexxer",     nKills: <?= $progress['zg'][7] ?> },
                                { name: "Gahz'ranka",            nKills: <?= $progress['zg'][8] ?> },
                                { name: "Edge of Madness",       nKills: <?= $progress['zg'][9] ?> }
                            ]
                        }
                    }
                );
            });
            //]]>
        </script>
    </div>
</div>
