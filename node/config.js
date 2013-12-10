var cloudinary;

cloudinary = process.env.CLOUDINARY_URL || 'cloudinary://232817971556963:_qiW6jeB6843KAq6mhtskeOlPc8@hwimucgdf';
cloudinary = cloudinary.split('//')[1].split(/[\:|\@]/);

module.exports = {
    host : {port : process.env.PORT || 3000, url : process.env.URL || 'localhost'},
    mongo : {uri : process.env.MONGOLAB_URI || 'mongodb://localhost:27017/galatea'},
    redis : {uri : process.env.REDISCLOUD_URL},
    cloudinary : {
        'cloud_name' : cloudinary[2],
        'api_key' : cloudinary[0],
        'api_secret' : cloudinary[1]
    }
};
