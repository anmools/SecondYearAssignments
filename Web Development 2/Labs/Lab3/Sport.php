
    <!DOCTYPE html>
    <html>
    <head>
        <title>Sport Club Feedback Form</title>
    </head>
    <body>
        <h1>Sport Club Feedback Form</h1>
        <p>Please fill in this form</p>
        <form>
            <label>Full name: </label>
            <input type="text" name="fullname"><br>
            <label>Email: </label>
            <input type="email" name="email"><br>

            <h2>Which sport do you prefer</h2>
            <input type="checkbox" name="sport" value="Swimming">
            <label for="sport1">Swimming</label><br>
            <input type="checkbox" name="sport" value="Football">
            <label for="sport2">Football</label><br>
            <input type="checkbox" name="sport" value="Tennis">
            <label for="sport3">Tennis</label><br>

            <h2>How long have you been a member of the club?</h2>
            <input type="radio" name="membership" value="Less than one year">
            <label for="Less">Less than one year</label><br>
            <input type="radio" name="membership" value="One to two years">
            <label for="More">One to two years</label><br>
            <input type="radio" name="membership" value="More than two years">
            <label for="Most">More than two years</label><br>

            <h2>Please give us some additional feedback you may have</h2>
            <label for="comments">Comments</label><br>
            <textarea id="comments" name="comments"></textarea><br>

            <button type="button">Submit</button>
            <button type="reset">Reset</button>
        </form>
    </body>
    </html>