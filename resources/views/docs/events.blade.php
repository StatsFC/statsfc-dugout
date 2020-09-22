<p>Get a list of events from the previous 48 hours, across all matches.</p>

<div class="panel panel-default">
    <div class="panel-heading solo">
        <pre>GET /events</pre>
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
            "id": 342777611,
            "matchTime": "63'",
            "type": "goal",
            "subType": null,
            "score": [
                5,
                0
            ],
            "match_id": 3114438,
            "team": {
                "id": 9259,
                "name": "Manchester City",
                "shortName": "Man City"
            },
            "player": {
                "id": 453102,
                "name": "P. Foden",
                "position": "MF"
            },
            "assist": {
                "id": 364017,
                "name": "Gabriel Jesus",
                "position": "FW"
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
                <td class="text-nowrap">
                    <samp>player</samp>
                    <i class="fa fa-long-arrow-right"></i>
                    <samp>position</samp>
                    <br>
                    <samp>assist</samp>
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
