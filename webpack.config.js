module.exports = {
  mode: 'development',
  entry: "./dev/js/index.js",
  output: {
    path: __dirname + '/public/js',
    filename: 'home.js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        // use: {
        //   loader: "babel-loader"
        // }
        loader: 'babel-loader',
        query: {
          plugins:[ 'transform-object-rest-spread' ]
        }
      }
    ]
  }
};