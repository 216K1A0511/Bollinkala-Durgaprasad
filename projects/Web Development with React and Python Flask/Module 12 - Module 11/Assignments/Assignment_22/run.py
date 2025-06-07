from flask import Flask, render_template, jsonify

app = Flask(__name__)

@app.route("/")
def index():
    return render_template("index.html")

@app.route("/status")
def status_update():
    # This can be used to update aria-live regions with dynamic content
    return jsonify({"status": "Speaking section started."})

if __name__ == "__main__":
    app.run(debug=True)
