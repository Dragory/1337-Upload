<div class="content-box">
    <h1>File listing</h1>
    <p>
        Files here!
    </p>

    <?php $files->appends(['order' => Input::get('order'), 'dir' => Input::get('dir')]); ?>
    {{ $files->links() }}
    <table class="table-generic" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th><a href="{{ URL::current().'?'.Listing::order('name') }}">File name</a></th>
                <th><a href="{{ URL::current().'?'.Listing::order('time') }}">Upload time</a></th>
                <th><a href="{{ URL::current().'?'.Listing::order('downloads') }}">Downloads</a></th>
                <th><a href="{{ URL::current().'?'.Listing::order('uploader') }}">Uploader</a></th>
                <th>Settings</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($files->results as $file) {
                if ($file->hide)
                {
                    echo '<tr><td colspan="5">File is hidden</td></tr>';
                }
                else
                {
                    $name = $file->file_name;
                    $extension = explode('.', $name);
                    $extension = array_pop($extension);

                    if (strlen($name) > 35) $name = substr($name, 0, 30).' - '.$extension;

                    echo '<tr>'.
                            '<td class="table-files-name"><a href="'.URL::base().'/files/'.$name.'">'.$name.'</a></td>'.
                            '<td class="table-files-time">'.date('d.m.Y', strtotime($file->file_upload_time)).'</td>'.
                            '<td class="table-files-downloads">'.number_format($file->file_downloads).'</td>'.
                            '<td class="table-files-uploader"><a href="'.URL::to_route('profile', array('id' => $file->id_user)).'">'.$file->user_username.'</a></td>'.
                            '<td class="table-files-settings">X H I</td>'.
                         '</tr>';
                }
            }
        ?>
        </tbody>
    </table>
    {{ $files->links() }}
</div>