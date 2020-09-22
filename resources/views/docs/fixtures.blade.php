<div class="panel panel-default">
    <div class="panel-heading solo">
        <pre>GET /fixtures</pre>
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
            "id": 21159,
            "timestamp": "2015-08-08T14:00:00+0000",
            "competition": {
                "id": 2,
                "name": "Premier League",
                "key": "EPL",
                "region": "England"
            },
            "round": {
                "id": 435,
                "name": "Premier League",
                "season": {
                    "id": 10,
                    "name": "2015\/2016"
                }
            },
            "teams": {
                "home": {
                    "id": 8,
                    "name": "Stoke City",
                    "shortName": "Stoke"
                },
                "away": {
                    "id": 1,
                    "name": "Liverpool",
                    "shortName": "Liverpool"
                }
            },
            "players": {
                "home": [],
                "away": []
            },
            "score": [
                0,
                0
            ],
            "currentState": "HT",
            "events": [
                "cards": [],
                "goals": [],
                "shootout": [],
                "substitutions": []
            ]
        }
    ]
}</code></pre>
        </div>
    </div>
</section>

<section>
    <h5>Optional Parameters</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><samp>season</samp></td>
                <td><samp>string</samp></td>
                <td>The name of the season the fixtures are in</td>
            </tr>
            <tr>
                <td><samp>season_id</samp></td>
                <td><samp>integer</samp></td>
                <td>The ID of the season the fixtures are in</td>
            </tr>
            <tr>
                <td><samp>competition</samp></td>
                <td><samp>string</samp></td>
                <td>The name of the competition the fixtures are in</td>
            </tr>
            <tr>
                <td><samp>competition_id</samp></td>
                <td><samp>integer</samp></td>
                <td>The ID of the competition the fixtures are in</td>
            </tr>
            <tr>
                <td><samp>competition_key</samp></td>
                <td><samp>string</samp></td>
                <td>The key of the competition the fixtures are in</td>
            </tr>
            <tr>
                <td><samp>team</samp></td>
                <td><samp>string</samp></td>
                <td>The name of the home or away team the fixtures are in</td>
            </tr>
            <tr>
                <td><samp>team_id</samp></td>
                <td><samp>integer</samp></td>
                <td>The ID of the home or away team the fixtures are in</td>
            </tr>
            <tr>
                <td><samp>from</samp></td>
                <td><samp>string</samp></td>
                <td>The earliest date to return fixtures from. This is a date in ISO 8601 format: <samp>YYYY-MM-DD</samp></td>
            </tr>
            <tr>
                <td><samp>to</samp></td>
                <td><samp>string</samp></td>
                <td>The latest date to return fixtures to. This is a date in ISO 8601 format: <samp>YYYY-MM-DD</samp></td>
            </tr>
        </tbody>
    </table>

    <p>At least one of the <code>season</code> or <code>season_id</code> parameters is <strong>required</strong>.</p>
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
                </ul>
            </td>
            <td>The current match state</td>
        </tr>
        </tbody>
    </table>
</section>
