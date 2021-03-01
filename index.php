<!doctype html>

<html lang="en">
    <head>
        <title>Crawler</title>
    </head>

    <body>
        <form method="POST" action="script.php">
            URL: <input type="text" name="url" value="https://forum.onliner.by/viewtopic.php?t=19991115"/>
            <br/>
            <br/>
            COMMENTS: <input type="text" name="comment_expression" value='//ul[@class="b-messages-thread"]/li[@id]'/>
            <br/>
            <br/>
            COMMENTS' TEXT: <input type="text" name="comment_text_expression" value='.//div[@class="content"]'/>
            <br/>
            <br/>
            COMMENTS' AUTHOR: <input type="text" name="comment_author_expression" value='.//big[starts-with(@class,"mtauthor-nickname userid")]//a[starts-with(@class,"_name")]' />
            <br/>
            <br/>
            <input type="checkbox" id="file" name="saveToFile">
            <label for="file">Save to file</label>            
            <input type="text" name="fileName" placeholder="Enter file name" />
            <br>
            <br>
            <input type="submit" />
        </form>
    </body>
</html>


