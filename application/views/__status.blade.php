<?php
    if (!empty($success) || !empty($error))
    {
        echo '<div id="content-status">';

        foreach ($error as $message)
        {
            echo '<div class="status-error">'.$message.'</div>';
        }

        foreach ($success as $message)
        {
            echo '<div class="status-success">'.$message.'</div>';
        }

        echo '</div>';
    }
?>