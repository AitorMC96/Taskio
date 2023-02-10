const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true
})

// Per poder tenir accés a la nostra API més fàcilment
module.exports = {
  devServer: {
    proxy: {
      '/api': {
        target: 'http://ruta_a_la_nostra_api',
        changeOrigin: true,
      }
    }
  },
  publicPath: './'
}
