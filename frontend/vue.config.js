const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  publicPath: process.env.BASE_URL || '/',
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/public': {
        target: 'http://localhost:8000', // Замените на URL вашего бэкенда
        changeOrigin: true,
      }
    },
  },
})
