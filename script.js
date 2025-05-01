const dragArea = document.querySelector('.drag-area');
const dragText = document.querySelector('.header');
const viewArea = document.querySelector('.view-area');


let file;
let filename = "filename.jpg"
let button = document.querySelector('.button');
let input = document.querySelector('.input');

//let submit = document.querySelector('.submit');
let download = document.querySelector('#download');



button.onclick = () => {
    input.click();
}
input.addEventListener('change', function() {
    file = this.files[0];
    console.log(file);
    dragArea.classList.add('active');
    displayFile();

    filename=file.name;
    document.getElementById("fname").textContent = filename;
    console.log(filename);
   var fd = new FormData();
   //var fileInput = document.getElementById('file');
   //var files = fileInput.files[0];
   fd.append('file', file);

   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'upload.php', true);

   xhr.onload = function () {
       if (xhr.status === 200) {
           var response = xhr.responseText;
           if (response !== "0") {

           } else {
               alert('file not uploaded');
           }
       } else {
           alert('An error occurred during the file upload.');
       }
   };

   xhr.send(fd);
})



download.onclick = () => {

    var fname=document.getElementById("download");
    displayOutput(fname);
  }


// when file is inside the drag area
dragArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    dragText.textContent = "Release to Upload";
    dragArea.classList.add('active');
    //console.log('file is inside the drag area');
});

// when file leaves the drag area
dragArea.addEventListener('dragleave', () => {
    dragText.textContent = "Drag & Drop";
    dragArea.classList.remove('active');
});

// when file is dropped in the drag area
dragArea.addEventListener('drop', (event) => {
    event.preventDefault();

    file = event.dataTransfer.files[0];
    //console.log(file);
    displayFile();

    //console.log('file is dropped inside the drag area');

    filename=file.name;
    document.getElementById("fname").textContent = filename;
    console.log(filename);

   var fd = new FormData();
   fd.append('file', file);

   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'upload.php', true);

   xhr.onload = function () {
       if (xhr.status === 200) {
           var response = xhr.responseText;
           if (response !== "0") {
               //console.log("File uploaded");
           } else {
               alert('file not uploaded');
           }
       } else {
           alert('An error occurred during the file upload.');
       }
   };

   xhr.send(fd);
})

function displayFile(){
    let fileType = file.type;
    let validExtensions = ['image/jpeg','image/jpg','image/png','image/heic','image/pdf'];

    if(validExtensions.includes(fileType)){
        let fileReader = new FileReader();

        fileReader.onload = () => {
            let fileURL = fileReader.result;
            //console.log(fileURL);
            let imgTag = `<img src="${fileURL}" id="previewImage" alt="">`;
            dragArea.innerHTML=imgTag;
        };
        fileReader.readAsDataURL(file);
    }else{
        alert('This File is Not an Image');
        dragArea.classList.remove('active');
    }
}

function displayOutput(response){
    let imgTag = `<img src="${response}" alt="">`;
    viewArea.classList.add('active');
    viewArea.innerHTML = "";
    viewArea.innerHTML=imgTag;

    download.href = response;
    console.log(response);
}

function loadPage(menu) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("html-content").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", menu, true);
    xhttp.send();
  }
