<!DOCTYPE html>
<html>
<head>
    <title>Language Selection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#languageModal">
    Choose Language
</button>

<!-- Modal -->
<div class="modal fade" id="languageModal" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="languageModalLabel">Language Selection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please select your preferred language:</p>
                <form method="post" action="process_document.php">
                    <div class="form-group">
                        <label for="language">Language:</label>
                        <select class="form-control" id="language" name="language">
                            <option value="english">English</option>
                            <option value="french">French</option>
                            <option value="spanish">Spanish</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Visualize Document</button>
                    <a href="download_document.php?language=<?php echo urlencode('english'); ?>" class="btn btn-success">Download Document</a>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
