<div class="input-group">
    <span class="input-group-addon" id="basic-addon1">
        <span class="glyphicon glyphicon-console" aria-hidden="true"></span>
    </span>
    <input type="text" class="form-control api-curl" aria-describedby="basic-addon1" value="curl -H &quot;X-StatsFC-Key: {api_key}&quot; https://dugout.statsfc.com/api/v2/events">
</div>

<pre><code class="json">{
    "data": [
        {
            "id": 342777611,
            "matchTime": "63'",
            "type": "goal",
            "subType": null,
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
