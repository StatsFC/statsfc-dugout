<p>Get a detailed list of all of today's games with live scores and match events, across all competitions.</p>

<div class="panel panel-default">
    <div class="panel-heading solo">
        <pre>GET /live</pre>
    </div>
</div>

<section>
    <h5>Response</h5>

    <div class="panel panel-default">
        <div class="panel-heading">
            <pre>Status: 200 OK</pre>
        </div>
        <div class="panel-body">
            <pre><code class="json">{
    "data": [
        {
            "id": 3389252,
            "timestamp": "2020-09-20T18:00:00+0000",
            "competition": {
                "id": 9,
                "name": "Premier League",
                "key": "EPL",
                "region": "England"
            },
            "round": {
                "id": 807,
                "name": "2020\/2021",
                "season": {
                    "id": 9,
                    "name": "2020\/2021"
                }
            },
            "teams": {
                "home": {
                    "id": 9240,
                    "name": "Leicester City",
                    "shortName": "Leicester"
                },
                "away": {
                    "id": 9072,
                    "name": "Burnley",
                    "shortName": "Burnley"
                }
            },
            "players": {
                "home": [
                    {
                        "id": 2841,
                        "number": 1,
                        "position": "GK",
                        "role": "starting",
                        "name": "K. Schmeichel"
                    },
                    …
                ],
                "away": [
                    {
                        "id": 220636,
                        "number": 1,
                        "position": "GK",
                        "role": "starting",
                        "name": "N. Pope"
                    },
                    …
                ]
            },
            "score": [
                1,
                1
            ],
            "currentState": "HT",
            "events": {
                "cards": [
                    {
                        "id": 36239771,
                        "matchTime": "8'",
                        "type": "card",
                        "subType": "first-yellow",
                        "team": {
                            "id": 9072,
                            "name": "Burnley",
                            "shortName": "Burnley"
                        },
                        "player": {
                            "id": 15915,
                            "name": "J. Rodriguez",
                            "position": "FW"
                        }
                    },
                    {
                        "id": 36239774,
                        "matchTime": "25'",
                        "type": "card",
                        "subType": "first-yellow",
                        "team": {
                            "id": 9240,
                            "name": "Leicester City",
                            "shortName": "Leicester"
                        },
                        "player": {
                            "id": 140912,
                            "name": "N. Mendy",
                            "position": "MF"
                        }
                    }
                ],
                "goals": [
                    {
                        "id": 36239772,
                        "matchTime": "10'",
                        "type": "goal",
                        "subType": null,
                        "team": {
                            "id": 9072,
                            "name": "Burnley",
                            "shortName": "Burnley"
                        },
                        "player": {
                            "id": 76918,
                            "name": "C. Wood",
                            "position": "FW"
                        }
                    },
                    {
                        "id": 36239773,
                        "matchTime": "20'",
                        "type": "goal",
                        "subType": null,
                        "team": {
                            "id": 9240,
                            "name": "Leicester City",
                            "shortName": "Leicester"
                        },
                        "player": {
                            "id": 454522,
                            "name": "H. Barnes",
                            "position": "MF"
                        },
                        "assist": {
                            "id": 297445,
                            "name": "T. Castagne",
                            "position": "DF"
                        }
                    }
                ],
                "shootout": [],
                "substitutions": [
                    {
                        "id": 36239775,
                        "matchTime": "40'",
                        "type": "substitution",
                        "subType": null,
                        "team": {
                            "id": 9072,
                            "name": "Burnley",
                            "shortName": "Burnley"
                        },
                        "playerOff": {
                            "id": 134040,
                            "name": "R. Brady",
                            "position": "MF"
                        },
                        "playerOn": {
                            "id": 2487,
                            "name": "E. Pieters",
                            "position": "DF"
                        }
                    }
                ]
            }
        }
    ]
}</code></pre>
        </div>
    </div>
</section>

<section>
    <h5>Possible Values</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Values</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-nowrap"><samp>currentState</samp></td>
                <td><samp>string</samp></td>
                <td>
                    <ul class="list-unstyled">
                        <li>
                            <samp>Int.</samp>
                            <small>(Interrupted)</small>
                        </li>
                        <li>
                            <samp>Delayed</samp>
                            <small>(Delayed)</small>
                        </li>
                        <li>
                            <samp>TBA</samp>
                            <small>(Time to be announced)</small>
                        </li>
                        <li>
                            <samp>14:30</samp>
                            <small>(Not started - match start time)</small>
                        </li>
                        <li>
                            <samp>23</samp>
                            <small>(Match in progress - current minute)</small>
                        </li>
                        <li>
                            <samp>HT</samp>
                            <small>(Half time)</small>
                        </li>
                        <li>
                            <samp>FT</samp>
                            <small>(Full time)</small>
                        </li>
                        <li>
                            <samp>P</samp>
                            <small>(Penalty shootout in progress)</small>
                        </li>
                        <li>
                            <samp>ET</samp>
                            <small>(Extra time)</small>
                        </li>
                        <li>
                            <samp>Break Time</samp>
                            <small>(Break time between extra time periods)</small>
                        </li>
                        <li>
                            <samp>Postp.</samp>
                            <small>(Postponed)</small>
                        </li>
                        <li>
                            <samp>Aban.</samp>
                            <small>(Abandoned)</small>
                        </li>
                        <li>
                            <samp>Cancl.</samp>
                            <small>(Cancelled)</small>
                        </li>
                        <li>
                            <samp>Susp.</samp>
                            <small>(Suspended)</small>
                        </li>
                        <li>
                            <samp>Delayed</samp>
                            <small>(Delayed)</small>
                        </li>
                        <li>
                            <samp>FT</samp>
                            <small>(Full time)</small>
                        </li>
                        <li>
                            <samp>Pen.</samp>
                            <small>(Match finished after penalty shootout)</small>
                        </li>
                        <li>
                            <samp>AET</samp>
                            <small>(Match finished after extra time)</small>
                        </li>
                        <li>
                            <samp>WO</samp>
                            <small>(Walkover)</small>
                        </li>
                        <li>
                            <samp>Awarded</samp>
                            <small>(Technical loss)</small>
                        </li>
                    </ul>
                </td>
                <td>The current match state</td>
            </tr>
            <tr>
                <td class="text-nowrap">
                    <samp>players</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>home</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>position</samp>
                    <br>
                    <samp>players</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>away</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>position</samp>
                    <br>
                    <samp>events</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>player</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>position</samp>
                </td>
                <td><samp>string</samp></td>
                <td>
                    <ul class="list-unstyled">
                        <li><samp>GK</samp></li>
                        <li><samp>DF</samp></li>
                        <li><samp>MF</samp></li>
                        <li><samp>FW</samp></li>
                    </ul>
                </td>
                <td>The player's general position</td>
            </tr>
            <tr>
                <td class="text-nowrap">
                    <samp>players</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>home</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>role</samp>
                    <br>
                    <samp>players</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>away</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>role</samp>
                </td>
                <td><samp>string</samp></td>
                <td>
                    <ul class="list-unstyled">
                        <li><samp>starting</samp></li>
                        <li><samp>sub</samp></li>
                    </ul>
                </td>
                <td>The player's role at the start of the match</td>
            </tr>
            <tr>
                <td class="text-nowrap">
                    <samp>events</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>type</samp>
                </td>
                <td><samp>string</samp></td>
                <td>
                    <ul class="list-unstyled">
                        <li><samp>goal</samp></li>
                        <li><samp>card</samp></li>
                        <li><samp>substitution</samp></li>
                        <li><samp>shootout</samp></li>
                    </ul>
                </td>
                <td>The primary type of the event</td>
            </tr>
            <tr>
                <td class="text-nowrap">
                    <samp>events</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>subType</samp>
                </td>
                <td><samp>string</samp></td>
                <td>
                    <ul class="list-unstyled">
                        <li>
                            <samp>penalty</samp>
                            <small>(relating to <samp>goal</samp> type)</small>
                        </li>
                        <li>
                            <samp>own-goal</samp>
                            <small>(relating to <samp>goal</samp> type)</small>
                        </li>
                        <li>
                            <samp>first-yellow</samp>
                            <small>(relating to <samp>card</samp> type)</small>
                        </li>
                        <li>
                            <samp>second-yellow</samp>
                            <small>(relating to <samp>card</samp> type)</small>
                        </li>
                        <li>
                            <samp>red</samp>
                            <small>(relating to <samp>card</samp> type)</small>
                        </li>
                        <li>
                            <samp>goal</samp>
                            <small>(relating to <samp>shootout</samp> type)</small>
                        </li>
                        <li>
                            <samp>miss</samp>
                            <small>(relating to <samp>shootout</samp> type)</small>
                        </li>
                    </ul>
                </td>
                <td>The secondary type of the event</td>
            </tr>
        </tbody>
    </table>
</section>
