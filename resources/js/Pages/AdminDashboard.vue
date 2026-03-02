<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Admin Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard Admin
      </h2>
    </template>

    <div class="py-6">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-500">Akses</p>
                <p class="text-lg font-semibold text-green-600">Admin</p>
              </div>

              <span class="rounded-full bg-green-50 px-3 py-1 text-sm text-green-700">
                SOP Management
              </span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
              <div class="rounded-lg border p-4">
                <p class="text-sm text-gray-500">Dokumen</p>
                <p class="mt-1 text-2xl font-bold">—</p>
              </div>

              <div class="rounded-lg border p-4">
                <p class="text-sm text-gray-500">Kategori</p>
                <p class="mt-1 text-2xl font-bold">—</p>
              </div>

              <div class="rounded-lg border p-4">
                <p class="text-sm text-gray-500">Terakhir update</p>
                <p class="mt-1 text-2xl font-bold">—</p>
              </div>
            </div>

            <p class="mt-6 text-sm text-gray-600">
              Halaman ini khusus admin. Nanti di sini kita buat tabel input link SOP (Google Drive/URL) + tombol Buka.
            </p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
