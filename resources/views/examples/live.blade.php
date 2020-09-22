<div class="input-group">
    <span class="input-group-addon" id="basic-addon1">
        <span class="glyphicon glyphicon-console" aria-hidden="true"></span>
    </span>
    <input type="text" class="form-control api-curl" aria-describedby="basic-addon1" value="curl -H &quot;X-StatsFC-Key: {api_key}&quot; https://dugout.statsfc.com/api/v2/live">
</div>

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
