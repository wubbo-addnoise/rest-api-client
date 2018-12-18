var http = require('http');
http.createServer(function (req, res) {
    var result, m;

    if (req.url.match(/\/objects$/)) {
        result = {
            "success": "true",
            "objects": [
                {
                    "id": 1,
                    "name": "Object 1",
                    "type": "Object type"
                },
                {
                    "id": 2,
                    "name": "Object 2",
                    "type": "Object type"
                }
            ]
        };
    } else if (m = req.url.match(/\/objects\/(\d+)$/)) {
        result = {
            "success": "true",
            "object": {
                "id": m[1],
                "name": "Object " + m[1],
                "type": "Object type"
            }
        };
    } else if (req.url.match(/\/objects\/(\d+)\/attributes/)) {
        result = {
            "success": "true",
            "attributes": [
                {
                    "id": 1,
                    "name": "Attribute 1",
                    "type": "Attribute type"
                },
                {
                    "id": 2,
                    "name": "Attribute 2",
                    "type": "Attribute type"
                }
            ]
        };
    } else {
        result = {
            "success": "true"
        };
    }

    res.writeHead(200, {'Content-Type': 'application/json'});
    res.write(JSON.stringify(result));
    res.end();
}).listen(8080);
