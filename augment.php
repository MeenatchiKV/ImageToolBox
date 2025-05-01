<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image Augmentation</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="style.css"/>
        <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    </head>
    <body>
    
    <?php include('header.html'); ?>
 

<br>
    <div class="container">
    <h3>Augment Images</h3>
<form id="uploadForm" method="post" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <td>
                <div class="drag-area" id="preview">
                    <div class="icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <span class="header"> Drag & Drop </span>
                    <span class="header"> or <span class="button">browse</span></span>
                    
                    <!-- Allow multiple files (folder upload via manual selection) -->
                    <input class="input" type="file" name="file" id="file" multiple webkitdirectory/>
                    
                    <span class="support">Supports: JPEG, JPG and PNG</span>
                </div>
            </td>
        </tr>
        <tr>
            <p> File Names: <span id="fname"> None </span></p>
        </tr>
    </table>
</form>

<table>
    <tr>
        <td>
            <div class="submit">
            <div class="card p-4">

            <h4>Selected the Augmentation Techniques</h4>
            <div id="augmentOptions">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="flip" value="flip">
                        <label class="form-check-label" for="binary">Flipping</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rotate" value="rotate">
                        <label class="form-check-label" for="bin-inv">Rotating</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="grey" value="grey">
                        <label class="form-check-label" for="bin-trunc">Greyscale</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="crop" value="crop">
                        <label class="form-check-label" for="bin-trunc">Crop</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="shear" value="shear">
                        <label class="form-check-label" for="set-0">Shear</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="zoom" value="zoom">
                        <label class="form-check-label" for="set-0-inv">Zoom</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="resize" value="resize">
                        <label class="form-check-label" for="otsu">Resize</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="random-erase" value="random-erase">
                        <label class="form-check-label" for="otsu">Random Erasing</label>
                    </div>

                    <h4>Enter Number of Images</h4>
                    <div class="mb-3">
                    <label for="num" class="form-label">How many imaged do you want to generate?*</label>
                        <input type="number" class="form-control" id="num" placeholder="Enter Number">
                    </div>
                </div>


            </div>
        </td>
        <td>
            <h3> <span id="augStatus">Let's Augment</span><h3>
        <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" id="augmentBTN" class="btn btn-outline-primary btn-custom">Apply</button>
                </div> 
        </td>

            <td>
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
</form> 
    </div>
    <script src="script-folder.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('augmentBTN').addEventListener("click", () => {
        
        let selectedValues = [];
        const checkboxes = document.querySelectorAll("#augmentOptions input[type='checkbox']");

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedValues.push(checkbox.value);
            }
        });

        console.log(selectedValues);



        var fname=document.getElementById("fname").textContent;
        var num = document.getElementById("num").value;
$.ajax({
    type: "POST",
    url: "http://localhost:5000/augment",
    contentType: "application/json",
    dataType: "text",
    data: JSON.stringify({
        o: [fname,selectedValues,num]
    }),
    error: function(xhr, status, error) {
        //displayOutput();
    },
    success: function(response){
        console.log(response);
        document.getElementById("augStatus").textContent = "Augmented Your Images. Click DOwnload.";
        displayOutput(response);
    }    

});    
});
});
    </script>
    </body>
</html>