<x-main>
    <!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Darslari</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="#" class="flex items-center py-4">
                            <i class="fas fa-graduation-cap text-2xl text-purple-600"></i>
                            <span class="font-semibold text-gray-500 text-lg ml-2">Laravel Darslari</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="#" class="py-2 px-4 text-gray-500 hover:text-purple-600 transition duration-300">Barcha darslar</a>
                    <a href="#" class="py-2 px-4 text-gray-500 hover:text-purple-600 transition duration-300">Blog</a>
                    <a href="#" class="py-2 px-4 text-gray-500 hover:text-purple-600 transition duration-300">Aloqa</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Video Section -->
            <div class="aspect-w-16 aspect-h-9">
                <img src="/api/placeholder/800/450" alt="Video placeholder" class="w-full h-64 object-cover">
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">1-dars: Laravel Framework ga kirish</h1>
                
                <div class="prose max-w-none">
                    <p class="text-gray-600 mb-4">
                        Laravel - bu zamonaviy PHP framework bo'lib, u web ilovalarni yaratish uchun mo'ljallangan. Bu darsda biz Laravel ning asosiy tushunchalarini, uning afzalliklarini va qanday o'rnatish kerakligini o'rganamiz.
                    </p>

                    <h2 class="text-2xl font-semibold text-gray-800 mt-6 mb-4">Dars rejasi:</h2>
                    <ul class="list-disc list-inside text-gray-600 mb-6">
                        <li>Laravel haqida umumiy ma'lumot</li>
                        <li>Laravel ning afzalliklari</li>
                        <li>Kerakli dasturlarni o'rnatish</li>
                        <li>Laravel ni o'rnatish</li>
                        <li>Birinchi loyihani yaratish</li>
                    </ul>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t">
                    <a href="#" class="flex items-center text-purple-600 hover:text-purple-800 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Oldingi dars
                    </a>
                    <a href="#" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300">
                        <i class="fas fa-home mr-2"></i>
                        Bosh sahifa
                    </a>
                    <a href="#" class="flex items-center text-purple-600 hover:text-purple-800 transition duration-300">
                        Keyingi dars
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Resources -->
        <div class="max-w-4xl mx-auto mt-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Qo'shimcha materiallar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition duration-300">
                    <h4 class="font-semibold text-gray-700">📚 Laravel Documentation</h4>
                    <p class="text-gray-600 mt-2">Rasmiy hujjatlar bilan tanishing</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition duration-300">
                    <h4 class="font-semibold text-gray-700">💻 Amaliy mashqlar</h4>
                    <p class="text-gray-600 mt-2">Dars bo'yicha mashqlarni bajarish</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-wrap justify-between items-center">
                <div class="w-full md:w-auto text-center md:text-left mb-4 md:mb-0">
                    <p>&copy; 2024 Laravel Darslari. Barcha huquqlar himoyalangan.</p>
                </div>
                <div class="w-full md:w-auto text-center md:text-right">
                    <a href="#" class="text-gray-400 hover:text-white mx-2">
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white mx-2">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white mx-2">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
</x-main>