<!-- sending form of image and comment -->

<form action="controller.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="page" value="PostingPage">
    <input type='hidden' name='command' value='PostingImage'>
    <label>Select Image File:</label>
    <input type="file" name="image">
    <input type="text" name="comment">
    <input type="submit" name="submit" value="Upload">
</form>
