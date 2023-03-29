<!DOCTYPE html>
<html>
<head>
	<title>Google Search Results Extractor</title>
	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Google Search Results Extractor</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="source_code">Source Code</label>
                            <textarea class="form-control" id="source_code" name="source_code" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Extract Text</button>
                    </form>

                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $source_code = $_POST['source_code'];
                            $texts = array();
                            preg_match_all('/<em>(.*?)<\/em>/', $source_code, $matches);
                            foreach ($matches[1] as $match) {
                                $texts[] = $match;
                            }
                            if (!empty($texts)) {
                                $uniqueTexts = array_unique($texts);
                                echo '<div class="mt-3"><strong>Extracted Text:</strong> ' . implode(', ', $uniqueTexts) . '</div>';
                                echo '<button class="btn btn-secondary mt-3" onclick="copyToClipboard()">Copy to Clipboard</button>';
                            } else {
                                echo '<div class="mt-3 alert alert-warning">No text found.</div>';  
                            }
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const extractedText = document.querySelector('.card-body strong').nextSibling.textContent.trim();
        const texts = extractedText.split(',');
        const uniqueTexts = [...new Set(texts)];
        const tempInput = document.createElement('input');
        tempInput.value = uniqueTexts.join(', ');
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
    }
</script>