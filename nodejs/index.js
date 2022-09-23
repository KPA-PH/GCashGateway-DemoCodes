var express = require('express');
var app = express();

app.get('/webhook', function(req, res){

    // capture the params query and do your data process
    var request = req.query
    // TO DO HERE...

    // you must respond in a JSON format same as below
    res.json({
        "status": 200,
        "message": "Got it.",
        "data_optional": request
    });
});
  
app.listen(3000);