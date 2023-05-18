// const proxy = require('http-proxy-middleware');

// module.exports = {
//   devServer: {
//     before: (app) => {
//       app.use('/movies_endpoint.php', proxy({
//         target: 'https://moviesdatabase.p.rapidapi.com/titles', // replace with your PHP server URL and port
//         changeOrigin: true,
//       }));
//     },
//   },
// };


// php -S localhost:8000