<!doctype html>

<html lang="en">
<link rel="stylesheet" href="style.css">

<head>
    <title>Crawler</title>
</head>

<body>
    <form method="POST" action="script.php">
        <div class="form_radio_btn">
            <input id="radio-1" type="radio" name="type" value="forum" >
            <label for="radio-1">Forum</label>
        </div>

        <div class="form_radio_btn">
            <input id="radio-2" type="radio" name="type" value="reddit" checked>
            <label for="radio-2">Reddit</label>
        </div> 
        <br>
        <br>
        URL: <input type="text" name="url" value="https://www.reddit.com/r/trance/comments/oio8i/ask_emma_hewitt_almost_anything/" />
        <br />
        <br />
        COMMENTS: <input type="text" name="comment_expression"  />
        <br />
        <br />
        COMMENTS' TEXT: <input type="text" name="comment_text_expression" />
        <br />
        <br />
        COMMENTS' AUTHOR: <input type="text" name="comment_author_expression" />
        <br />
        <br />
        <input type="submit" />
    </form>
</body>

</html>