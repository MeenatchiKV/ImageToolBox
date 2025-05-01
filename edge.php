<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edge Detection</title>
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
    <h3>Canny Edge Detection</h3>
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
                        <input class="input" type="file" name="file" id="file" hidden/>
                        <span class="support">Supports: JPEG, JPG and PNG</span>
                    </div>
            </td>
            <td>
                <div class="view-area">
                    <div class="icon">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <p> File Name: <span id="fname"> None </span></p>
        </tr>

</table>
<table>
    <tr>
        <td>
        <div class="card p-4">
        <div class="submit">
            <div class="slider-container" style="padding: 5px;">
                <label for="thresholdRange1" class="form-label">Threshold 1: <span id="sliderValue1">70</span></label>
                <input type="range" class="form-range" id="thresholdRange1" min="0" max="255" step="1" value="70">
            </div>

            <div class="slider-container" style="padding: 5px;">
                <label for="thresholdRange2" class="form-label">Threshold 2: <span id="sliderValue2">135</span></label>
                <input type="range" class="form-range" id="thresholdRange2" min="0" max="255" step="1" value="135">
            </div>

            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <button type="button" id="edgeBTN" class="btn btn-outline-primary">Detect Edges</button>
            </div> 

       
        </div>
        </div>
        </td>

        <td>

        <div class="card p-4">
            <div class="download">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a id="download" type="button" class="btn btn-outline-primary btn-custom" download>Download</a>
                </div> 
            </div>

                <div class="Reset">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <a id="reset" href="" type="button" class="btn btn-outline-primary btn-custom">Reset</a>
                    </div> 
                </div>
            </div>
            </td>
</tr>
    
        
    </table> 
</form> 
    </div>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        document.getElementById("thresholdRange1").addEventListener("input", function() {
            document.getElementById("sliderValue1").textContent = this.value;
        });

        document.getElementById("thresholdRange2").addEventListener("input", function() {
            document.getElementById("sliderValue2").textContent = this.value;
        });

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('edgeBTN').addEventListener("click", () => {
        var fname=document.getElementById("fname").textContent;
        var t1=document.getElementById("sliderValue1").textContent;
        var t2=document.getElementById("sliderValue2").textContent;
$.ajax({
    type: "POST",
    url: "http://localhost:5000/edge",
    contentType: "application/json",
    dataType: "text",
    data: JSON.stringify({
        o: [fname,t1,t2]
    }),
    error: function(xhr, status, error) {
        //displayOutput();
    },
    success: function(response){
        console.log(response);
        displayOutput(response);
    }    

});    
});
});
    </script>
    </body>
</html>