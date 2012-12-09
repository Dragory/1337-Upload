qq.FineUploaderLeet = function(o)
{
    qq.FineUploader.apply(this, arguments);
};

qq.extend(qq.FineUploaderLeet.prototype, qq.FineUploader.prototype);

qq.extend(qq.FineUploaderLeet.prototype, {
    // We need to extend the submit function to
    // add our login identifier to the request
    // to make sure our login doesn't time out
    // (even when the user doesn't have "stay
    // logged in" checked)
    _onSubmit: function(id, filename)
    {
        this.setParams({'token': token});
        qq.FineUploader.prototype._onSubmit.apply(this, arguments);
    }
});

var uploader = new qq.FineUploaderLeet({
    element: document.getElementById('uploader'),
    request: {
        endpoint: uploadUrl
    }
});



/*qq.LeetUploader = function(o)
{
    qq.FineUploaderBasic.apply(this, arguments);

};

qq.extend(qq.LeetUploader.prototype, qq.FineUploaderBasic.prototype);
qq.extend(qq.LeetUploader.prototype, {
    dragAndDrop: function()
    {
        console.log(this);
    }
});*/



/*qq.extend(qq.FineUploaderBasic.prototype, {
    _setupDragDrop: function()
    {
        var self, dropArea;

        self = this;

        dropArea = this._find(this._element, 'drop');
        this._options.dragAndDrop.extraDropzones.push(dropArea);

        var dropzones = this._options.dragAndDrop.extraDropzones;
        var i;
        for (i=0; i < dropzones.length; i++){
            this._setupDropzone(dropzones[i]);
        }

        // IE <= 9 does not support the File API used for drag+drop uploads
        if (!qq.ie() || qq.ie10()) {
            this._attach(document, 'dragenter', function(e){
                if (qq(dropArea).hasClass(self._classes.dropDisabled)) return;

                dropArea.style.display = 'block';
                for (i=0; i < dropzones.length; i++){ dropzones[i].style.display = 'block'; }

            });
        }

        this._attach(document, 'dragleave', function(e){
            if (self._options.dragAndDrop.hideDropzones && qq.FineUploader.prototype._leaving_document_out(e)) {
                for (i=0; i < dropzones.length; i++) {
                    qq(dropzones[i]).hide();
                }
            }
        });

        qq(document).attach('drop', function(e){
            for (i=0; i < dropzones.length; i++) {
                qq(dropzones[i]).hide();
            }
            e.preventDefault();
        });
    }
});*/

/*var LeetUploader = function()
{
    var self = this;

    // An array containing the list elements
    // of every file we're uploading.
    this.files = {};

    // The uploader itself
    this.$uploader = $('#uploader');
    if (this.$uploader.length <= 0) return;

    // Uploader elements
    this.$uploadButton = $('#uploader-button');

    // Create the uploader
    var uploader = this.$uploader.fineUploader({
        request: {
            endpoint: uploadUrl
        }
    })
    .on('submit', function(event, id, filename) {
        self.handleSubmit(event, id, filename);
    })
    .on('complete', function(event, id, filename, response) {
        self.handleComplete(event, id, filename, response);
    });
};

LeetUploader.prototype.handleSubmit = function(event, id, filename)
{
    this.$uploader.fineUploader('setParams', {'csrf_token': csrf_token});

    var $fileLine = $('<div></div>');
    $fileLine.text('Uploading ' + filename);

    $('#uploader-files').append($fileLine);

    this.files[id] = $fileLine;
};

LeetUploader.prototype.handleComplete = function(event, id, filename, response)
{
    if (this.files[id] == undefined) return;

    if (response.success)
    {

    }
    else
    {
        this.files[id].text('NOPE.');
    }
};

var uploader = new LeetUploader;
// console.log(qq.LeetUploader);*/