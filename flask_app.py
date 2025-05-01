# importing Flask and other modules
from flask import Flask, request, jsonify
from fileinput import filename 
from flask_cors import CORS
import cv2
from PIL import Image
import os
from datetime import datetime
import Augmentor
import shutil

def zip_folder(folder_path, output_zip):
    shutil.make_archive(output_zip, 'zip', folder_path)
    return f"{output_zip}.zip"


# Flask constructor
app = Flask(__name__) 
CORS(app, origins=["http://localhost/ImageToolBox/"])

@app.after_request
def add_cors_headers(response):
    response.headers["Access-Control-Allow-Origin"] = "*"
    response.headers["Access-Control-Allow-Methods"] = "POST, GET, OPTIONS"
    response.headers["Access-Control-Allow-Headers"] = "Content-Type"
    return response


# A decorator used to tell the application
# which URL is associated function
@app.route('/greyscale/<fname>', methods =["POST","GET"])
def greyscale(fname):
    print(f"File Recieved: {fname}")
    if request.method in ["POST","GET"]:
        img = cv2.imread('uploads/'+fname)
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        new_fname = f"converts/{timestamp}_{fname}"
        gray_image = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        cv2.imwrite(new_fname, gray_image)
        print("New filename is: ",new_fname)
    return new_fname

@app.route('/thresholding/<options>', methods =["POST","GET"])
def threshold(options):
    data = request.json  # Ensure proper JSON decoding
    thresh = float(data['o'][1])
    fname = data['o'][0]
    print(f"File Recieved: {fname}")

    if request.method in ["POST","GET"]:
        img = cv2.imread('uploads/'+fname)
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        new_fname = f"converts/{timestamp}_{fname}"

        if options=="binary":
            ret, thres_out = cv2.threshold(img, thresh, 255, cv2.THRESH_BINARY)
            cv2.imwrite(new_fname, thres_out)
        elif options=="bin-inv":
            ret, thres_out = cv2.threshold(img, thresh, 255, cv2.THRESH_BINARY_INV)
            cv2.imwrite(new_fname, thres_out)
        elif options=="bin-trunc":
            ret, thres_out = cv2.threshold(img, thresh, 255, cv2.THRESH_TRUNC)
            cv2.imwrite(new_fname, thres_out) 
        elif options=="set-0":
            ret, thres_out = cv2.threshold(img, thresh, 255, cv2.THRESH_TOZERO)
            cv2.imwrite(new_fname, thres_out)
        elif options=="set-0-inv":
            ret, thres_out = cv2.threshold(img, thresh, 255, cv2.THRESH_TOZERO_INV)
            cv2.imwrite(new_fname, thres_out)
        elif options=="otsu":
            img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
            ret, thres_out = cv2.threshold(img, 120, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
            cv2.imwrite(new_fname, thres_out)
        print("New filename is: ",new_fname)
    return new_fname

@app.route('/denoising/<options>', methods =["POST","GET"])
def denoise(options):
    data = request.json  # Ensure proper JSON decoding
    fname = data['o']
    print(f"File Recieved: {fname}")

    if request.method in ["POST","GET"]:
        img = cv2.imread('uploads/'+fname)
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        new_fname = f"converts/{timestamp}_{fname}"

        if options=="high":
            dst = cv2.fastNlMeansDenoisingColored(img, None, 15, 15, 31, 15)
            cv2.imwrite(new_fname, dst)
        elif options=="medium":
            dst = cv2.fastNlMeansDenoisingColored(img, None, 10, 10, 21, 7)
            cv2.imwrite(new_fname, dst)
        elif options=="low":
            dst = cv2.fastNlMeansDenoisingColored(img, None, 5, 5, 11, 3)
            cv2.imwrite(new_fname, dst) 
        
        print("New filename is: ",new_fname)
    return new_fname

@app.route('/edge', methods =["POST","GET"])
def edge():
    data = request.json  # Ensure proper JSON decoding
    fname = data['o'][0]
    t1=float(data['o'][1])
    t2=float(data['o'][2])
    print(f"File Recieved: {fname}")

    if request.method in ["POST","GET"]:
        img = cv2.imread('uploads/'+fname)
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        new_fname = f"converts/{timestamp}_{fname}"
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        blurred = cv2.GaussianBlur(src=gray, ksize=(3, 3), sigmaX=(2/6))
        edges = cv2.Canny(blurred, t1, t2)
        cv2.imwrite(new_fname, edges)  
        print("New filename is: ",new_fname)
    return new_fname

@app.route('/compress', methods =["POST","GET"])
def compress():
    data = request.json  # Ensure proper JSON decoding
    fname = data['o'][0]
    p=100-int(data['o'][1])
    print(f"File Recieved: {fname}")
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    new_fname = f"converts/{timestamp}_{fname}"
    if request.method in ["POST","GET"]:
        img = Image.open('uploads/'+fname)
        width, height = img.size
        new_size = (width//2, height//2)
        resized_image = img.resize(new_size)
        resized_image.save(new_fname, optimize=True, quality=p)
        original_size = round(os.path.getsize('uploads/'+fname)/1024,2)
        compressed_size = round(os.path.getsize(new_fname)/1024,2)
        print("New filename is: ",new_fname)
        print(f"Old File Size: {original_size} KB")
        print(f"New File Size: {compressed_size} KB")
    return jsonify({'fname': new_fname, 'origsize': original_size, 'newsize': compressed_size})

@app.route('/resize', methods =["POST","GET"])
def resize():
    data = request.json  # Ensure proper JSON decoding
    fname = data['o'][0]
    w=int(data['o'][1])
    h=int(data['o'][2])
    print(f"File Recieved: {fname}")
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    new_fname = f"converts/{timestamp}_{fname}"
    if request.method in ["POST","GET"]:
        img = Image.open('uploads/'+fname)
        width, height = img.size
        new_size = (w,h)
        resized_image = img.resize(new_size)
        resized_image.save(new_fname)
        print("New filename is: ",new_fname)
        print(f"Old File Size: {width}x{height}px")
        print(f"New File Size: {w}x{h}px")
    return jsonify({'fname': new_fname, 'nw': w, 'nh': h, 'w':width, 'h':height})

@app.route('/crop', methods=["POST"])
def crop_image():
    file = request.files.get("croppedImage")
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    new_fname = f"converts/{timestamp}_cropped.png"
    if file:
        file.save(new_fname)
        print(new_fname)
        return jsonify({"fname": new_fname})
    return jsonify({"error": "No image received"}), 400

@app.route('/augment', methods =["POST","GET"])
def augment():
    data = request.json  # Ensure proper JSON decoding
    options = data['o'][1]
    fname = data['o'][0]
    num = int(data['o'][2])
    print("number of images", num)
    print(f"File Recieved: {fname}")
    print(options)
    
    output_folder = "uploads/output"

    # Ensure the folder exists
    if os.path.exists(output_folder):
        for file in os.listdir(output_folder):
            file_path = os.path.join(output_folder, file)
            try:
                os.remove(file_path)  # Delete file
            except Exception as e:
                print(f"Error deleting {file_path}: {e}")

        print("All files deleted before augmentation.")
    else:
        print("Output folder does not exist.")

    p = Augmentor.Pipeline('uploads')

    if request.method in ["POST","GET"]:
        img = cv2.imread('uploads/'+fname)
        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        new_fname = f"converts/{timestamp}_{fname}"
        print("New filename is: ",new_fname)

        if 'flip' in options:
            p.flip_left_right(0.5)
            p.flip_top_bottom(probability=0.3)
        if 'rotate' in options:
            p.rotate(0.3, 10, 10)
            p.rotate90(probability=0.2)
            p.rotate270(probability=0.2)
        if 'grey' in options:
            p.black_and_white(0.1)
        if 'shear' in options:
            p.skew(0.4, 0.5)
        if 'zoom' in options:
            p.zoom(probability = 0.2, min_factor = 1.1, max_factor = 1.5)
        if 'crop' in options:
            p.crop_random(probability=1, percentage_area=0.5)
        if 'random-erase' in options:
            p.random_distortion(probability=1, grid_width=4, grid_height=4, magnitude=8)
        if 'resize' in options:
            p.resize(probability=1.0, width=120, height=120)

        p.sample(num)
        zip_file_path = zip_folder("uploads/output", "uploads/output_compressed")

            
    return "uploads/output_compressed.zip"


if __name__=='__main__':
    app.run(debug=True)
