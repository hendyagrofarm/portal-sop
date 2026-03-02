<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Portal SOP - PT Agrofarm Nusa Raya" />

  <div class="min-h-screen bg-gray-50 flex flex-col">

    <!-- Header -->
    <header class="border-b border-gray-200 bg-white">
      <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">
        <div class="flex items-center gap-3">
          <img src="/images/logo.png" class="h-10 w-auto" alt="Logo" />
          <div class="leading-tight">
            <div class="text-sm font-semibold text-gray-900">
              PT Agrofarm Nusa Raya
            </div>
            <div class="text-xs text-gray-500">
              Portal SOP
            </div>
          </div>
        </div>

        <Link
          :href="route('login')"
          class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
        >
          Masuk
        </Link>
      </div>
    </header>

    <!-- Main Section -->
    <main class="flex flex-1 items-center justify-center px-6">
      <div class="w-full max-w-4xl text-center">

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
          Selamat Datang di Portal SOP
        </h1>

        <p class="mt-6 text-base leading-relaxed text-gray-600">
          Portal ini merupakan sistem internal PT Agrofarm Nusa Raya
          yang digunakan untuk pengelolaan dan akses dokumen Standar Operasional Prosedur (SOP).
        </p>

        <div class="mt-10 flex justify-center gap-4">
          <Link
            :href="route('login')"
            class="rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700"
          >
            Masuk ke Sistem
          </Link>


        </div>

        <div class="mt-12 text-sm text-gray-500">
          Akses sistem diberikan berdasarkan peran pengguna silahkan hubungi Administrator
        </div>

      </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white py-5 text-center text-xs text-gray-500">
      © {{ new Date().getFullYear() }} PT Agrofarm Nusa Raya • Sistem Dokumentasi Internal
    </footer>

  </div>
</template>
