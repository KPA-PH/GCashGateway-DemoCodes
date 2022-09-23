from flask import Flask, request
import os, time

app = Flask(__name__)

@app.route('/webhook', methods=['GET'])
def search():

    #// capture the params query and do your data process
    args = request.args
    #// TO DO HERE...

    #// you must respond in a JSON format same as below
    resJson = {
        "status": 200,
        "message": "got it.",
        "data_optional": args #// not required
    }
    return resJson

if __name__ == "__main__":
    app.secret_key = os.urandom(12)
    app.run(debug=True, host="0.0.0.0", port="21000")