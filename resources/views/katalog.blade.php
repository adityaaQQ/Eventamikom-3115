<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Katalog - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans">
    <nav class="bg-white shadow-md p-4 flex justify-center gap-4 text-slate-600 font-medium">
        <a href="/" class="px-4 py-2 hover:text-purple-600">Home</a>
        <a href="/profil" class="px-4 py-2 hover:text-purple-600">Profil</a>
        <a href="/katalog" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md">Katalog</a>
        <a href="/bantuan" class="px-4 py-2 hover:text-purple-600">Bantuan</a>
    </nav>

    <div class="max-w-5xl mx-auto mt-10 p-6">
        <h1 class="text-3xl font-bold text-slate-800 mb-8">Katalog Event Amikom</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-100 hover:scale-105 transition">
                <div class="h-40 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                <div class="p-5">
                    <h3 class="font-bold text-xl">Seminar Nasional Tech</h3>
                    <p class="text-slate-500 text-sm mt-2">Daftar event teknologi terbaru di Amikom.</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-100 hover:scale-105 transition">
                <div class="h-40 bg-gradient-to-r from-purple-500 to-pink-600"></div>
                <div class="p-5">
                    <h3 class="font-bold text-xl">Workshop UI/UX</h3>
                    <p class="text-slate-500 text-sm mt-2">Pelajari desain interface modern.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>