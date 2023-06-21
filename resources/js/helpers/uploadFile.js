// This function is used to detect the actual image type,

const getMimeType = (file, fallback = null) => {
    const byteArray = new Uint8Array(file).subarray(0, 4);
    let header = "";
    for (let i = 0; i < byteArray.length; i++) {
        header += byteArray[i].toString(16);
    }
    switch (header) {
        case "89504e47":
            return "image/png";
        case "47494638":
            return "image/gif";
        case "ffd8ffe0":
        case "ffd8ffe1":
        case "ffd8ffe2":
        case "ffd8ffe3":
        case "ffd8ffe8":
            return "image/jpeg";
        default:
            return fallback;
    }
};

const loadImageHelper = (event) => {
    let files = event.target.files;

    var image = {
        src: null,
        type: null,
    };

    if (files && files[0]) {
        if (image.src) {
            URL.revokeObjectURL(image.src);
        }

        console.log(files[0]);
        const blob = URL.createObjectURL(files[0]);
        image.src = blob;

        image.type = getMimeType(event.target.result, files[0].type);
        return image;
    } else {
        return false;
    }
};

export { loadImageHelper, getMimeType };
