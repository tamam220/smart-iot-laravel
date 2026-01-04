# Smart IoT Platform

Platform IoT berbasis Web yang memungkinkan pengguna mengontrol dan memonitor perangkat keras (ESP8266/ESP32) secara Real-time menggunakan protokol MQTT.

🌐 **Live Demo:** [https://smart-iot.infinityfreeapp.com](https://smart-iot.infinityfreeapp.com)

## ✨ Fitur Utama
* **Real-time Control:** Menggunakan MQTT (WebSocket Secure) untuk latensi rendah.
* **Google Login:** Integrasi OAuth untuk login cepat dan aman.
* **Multi-Device:** Pengguna dapat menambahkan banyak perangkat (Lampu, Sensor, dll).
* **Responsive UI:** Tampilan dashboard yang rapi di Desktop maupun Mobile.

## 🛠️ Teknologi yang Digunakan
* **Backend:** Laravel 11
* **Frontend:** Blade, Tailwind CSS, JavaScript (MQTT.js)
* **Database:** MySQL
* **IoT Protocol:** MQTT (via EMQX Broker)
* **Hardware:** Wemos D1 Mini / ESP32

## 🚀 Cara Instalasi (Hardware)
Jika Anda ingin menghubungkan alat (Wemos D1 Mini) ke platform ini:

1.  Buat akun di website dan buat Device baru.
2.  Salin **Topic/Token** yang muncul.
3.  Gunakan library `PubSubClient` di Arduino IDE.
4.  Hubungkan ke Broker: `broker.emqx.io` port `1883`.
5.  Subscribe ke topic yang Anda dapatkan di dashboard.

## 📦 Instalasi Local (Untuk Developer)
1. Clone repo ini:
   ```bash
   git clone [https://github.com/username-kamu/smart-iot-laravel.git](https://github.com/username-kamu/smart-iot-laravel.git)
