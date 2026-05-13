<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Konwerter formatów</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            display: flex;
            gap: 20px;
        }

        textarea {
            width: 400px;
            height: 300px;
        }

        .panel {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        select, button {
            padding: 5px;
        }
    </style>
</head>
<body>

<h1>Konwerter formatów</h1>

<form method="POST">

    <div class="container">

        <div class="panel">

            <select name="input_format">
                <?php foreach ($formats as $format): ?>

                    <option
                            value="<?= $format ?>"
                        <?= $inputFormat === $format ? 'selected' : '' ?>
                    >
                        <?= $format ?>
                    </option>

                <?php endforeach; ?>
            </select>

            <textarea name="input"><?= htmlspecialchars($input) ?></textarea>

        </div>

        <div class="panel">

            <select name="output_format">
                <?php foreach ($formats as $format): ?>

                    <option
                            value="<?= $format ?>"
                        <?= $outputFormat === $format ? 'selected' : '' ?>
                    >
                        <?= $format ?>
                    </option>

                <?php endforeach; ?>
            </select>

            <textarea readonly><?= htmlspecialchars($output) ?></textarea>

        </div>

    </div>

    <br>

    <button type="submit">Convert</button>

</form>

</body>
</html>