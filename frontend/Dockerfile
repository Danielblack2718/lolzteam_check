# Dockerfile для проекта Vue.js
FROM node:lts-alpine

# Установка рабочего каталога
WORKDIR /app

# Копирование файлов проекта
COPY . .

# Установка зависимостей
RUN npm install

# Запуск проекта
CMD ["npm", "run", "serve"]
