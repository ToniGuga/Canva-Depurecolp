var FtpDeploy = require("ftp-deploy");
var ftpDeploy = new FtpDeploy();

var config = {
    user: "schiavoneguga.com",
    // Password optional, prompted if none given
    password: "K9buXuQSTWZFVH6aoLTEvy",
    host: "ssh.schiavoneguga.com",
    port: 22,
    localRoot: __dirname,
    remoteRoot: "/customers/2/8/e/schiavoneguga.com/httpd.www/progetti/canva/wp-content/themes/Canva-Theme/",
    // include: ["*", "**/*"],      // this would upload everything except dot files
    include: ["*.php", "*.css", "*.html", "*.js", "core/**/*", "core/**/*", ".*"],
    // e.g. exclude sourcemaps, and ALL files in node_modules (including dot files)
    exclude: ["node_modules/**", "node_modules/**/.*", ".git/**", "*.ini", "*.json", "*.config.js", ".DS_Store", ".desktop.ini", ".gitignore"],
    // delete ALL existing files at destination before uploading, if true
    deleteRemote: false,
    // Passive mode is forced (EPSV command is not sent)
    forcePasv: true,
    // use sftp or ftp
    sftp: true
};

ftpDeploy
    .deploy(config)
    .then(res => console.log("finished:", res))
    .catch(err => console.log(err));