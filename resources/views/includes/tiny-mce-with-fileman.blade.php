<script>
    //text editor
    tinymce.init({
        selector: '.tiny',
        height: 400,
        min_height: 300,
        max_height: 500,
        plugins: 'image, link, media, wordcount, lists, code, table, preview',
        toolbar: ['formatselect | bold italic strikethrough superscript subscript forecolor backcolor formatpainter | table link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat code'],

        path_absolute : "/",
        file_picker_callback: function (callback, value, meta) {
            window.addEventListener('message', function receiveMessage(event) {
                window.removeEventListener('message', receiveMessage, false);
                if (event.data.sender === 'TestFM') {
                    callback(event.data.url);
                    tinymce.activeEditor.windowManager.close();
                }
            }, false);
            tinymce.activeEditor.windowManager.openUrl({
                title: 'File manager',
                url: '/bank/data/filemanager/view?view=text-editor',
                width: 1000,
                height: 600,
                resizable: true,
                maximizable: true,
                inline: 1,
            });
        },
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
    });
</script>
