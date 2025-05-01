<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Cropper</title>
    <link rel="stylesheet" href="style.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
<body>
    <?php include('header.html'); ?>
    <div class="container mt-5">

<table>
<p> <span id="status"> let's crop </span> <p>
        <h2>Upload and Crop Image</h2>
    <tr>
    <input type="file" id="imageInput" class="form-control mb-3">
        <td>
        

        <div class="drag-area" id="preview">
                        <img id="previewImage" style="max-width: 100%;" alt="Preview" hidden>

                    </div>

        </div>
        </td>
        
        <td>
        <div class="view-area" id="view-area">
                    <div class="icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <img id="outImage" style="max-width: 100%;" alt="Preview" hidden>
        </div>
        </td>
        
    </tr>
    <tr>
            <p> File Name: <span id="fname"> None </span></p>
            <p> Adjust the image to crop </p>
        </tr>

        <tr>
        <td>
            <div class="submit">

                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" id="HflipButton" class="btn btn-outline-primary">Horizontal Flip</button>
                </div>
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" id="VflipButton" class="btn btn-outline-primary btn-custom">Vertical Flip</button>
                </div>
            </div>
        </td>
        <td>
            <div class="submit>
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" id="cropButton" class="btn btn-outline-primary btn-custom">Apply</button>
                </div>
            </div>
            <div class="download">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a id="download" type="button" class="btn btn-outline-primary btn-custom" download>Download</a>
                </div> 
            </div>
        </td>
        <td>
            <div class="Reset">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a id="reset" href="" type="button" class="btn btn-outline-primary btn-custom">Reset</a>
                </div> 
            </div>
        </td>
    </tr>
</table>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        
        document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("cropButton").addEventListener("click", function() {
            if (cropper) {
                
                const croppedCanvas = cropper.getCroppedCanvas();
                croppedCanvas.toBlob(blob => {
                    const formData = new FormData();
                    formData.append("croppedImage", blob);
                
                    $.ajax({
    type: "POST",
    url: "http://localhost:5000/crop",
    contentType: false,
    processData: false,
    data: formData,
    error: function(xhr, status, error) {
        //displayOutput();
    },
    success: function(response){
        var jsonResponse = typeof response === "string" ? JSON.parse(response) : response;
        document.getElementById("status").textContent = "Cropped. Press Download";
        document.getElementById("download").href = jsonResponse.fname;
        if (jsonResponse.fname) {
            const outImage = document.getElementById('outImage');
            if (outImage) {
                outImage.src = jsonResponse.fname;
                outImage.hidden = false;
                console.log("Image updated successfully:", jsonResponse.fname);
            } else {
                console.error("Error: 'outImage' element not found!");
            }
        } 
       // let imgTag = `<img src="${jsonResponse.fname}" alt="">`;
    //var viewArea = document.getElementById('view-area');
    //viewArea.classList.add('active');
    //viewArea.innerHTML = "";
    //viewArea.innerHTML=imgTag;

    } 
});
}, "image/png");
}
});
        });

let cropper;
        document.getElementById("imageInput").addEventListener("change", function(event) {
            const image = document.getElementById("previewImage");
            image.src = URL.createObjectURL(event.target.files[0]);

            image.onload = function() {
                cropper = new Cropper(image, {
                    aspectRatio: NaN, // Removes aspect ratio constraint
                    autoCropArea: 0.8, // Sets the initial cropping area size
                    viewMode: 0, // Allows free movement and scaling
                    movable: true, // Enables dragging of the cropped area
                    scalable: true, // Enables resizing the crop box
                    zoomable: true, // Allows zooming
                    rotatable: true, // Enables rotation
                    cropBoxResizable: true // Allows resizing the crop box freely
                });
                
            };
        });

        document.getElementById("HflipButton").addEventListener("click", function() {
    if (cropper) {
        cropper.scaleX(cropper.getData().scaleX * -1); // Flip horizontally
    }
});

document.getElementById("VflipButton").addEventListener("click", function() {
    if (cropper) {
        cropper.scaleY(cropper.getData().scaleY * -1); // Flip horizontally
    }
});



    </script>
</body>
</html>