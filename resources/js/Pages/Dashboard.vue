<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  stats: Object,
  latestDocuments: Array,
  categoryBreakdown: Array,
})
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Dashboard Portal SOP
        </h2>

        <Link
          :href="route('documents.index')"
          class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
        >
          Lihat Dokumen
        </Link>
      </div>
    </template>

    <div class="py-6">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
            <div class="text-sm text-gray-500">Total Dokumen</div>
            <div class="mt-2 text-3xl font-semibold text-gray-900">
              {{ stats.totalDocuments }}
            </div>
          </div>

          <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
            <div class="text-sm text-gray-500">Total Departemen</div>
            <div class="mt-2 text-3xl font-semibold text-gray-900">
              {{ stats.totalCategories }}
            </div>
          </div>

          <div
            v-if="stats.totalUsers !== null"
            class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100"
          >
            <div class="text-sm text-gray-500">Total User</div>
            <div class="mt-2 text-3xl font-semibold text-gray-900">
              {{ stats.totalUsers }}
            </div>
            <div class="mt-1 text-xs text-gray-400">Khusus admin</div>
          </div>
        </div>

        <!-- LATEST DOCS -->
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
          <div class="border-b border-gray-100 p-5">
            <div class="flex items-center justify-between">
              <h3 class="text-base font-semibold text-gray-800">Dokumen Terbaru</h3>
              <Link
                :href="route('documents.index')"
                class="text-sm font-medium text-green-700 hover:underline"
              >
                Buka semua
              </Link>
            </div>
          </div>

          <div class="p-5">
            <div v-if="!latestDocuments.length" class="text-sm text-gray-500">
              Belum ada dokumen.
            </div>

            <div v-else class="overflow-x-auto">
              <table class="w-full text-left text-sm">
                <thead class="border-b bg-gray-50 text-gray-600">
                  <tr>
                    <th class="px-4 py-3">Nomor</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Departemen</th>
                    <th class="px-4 py-3">Update</th>
                    <th class="px-4 py-3">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="doc in latestDocuments" :key="doc.id" class="border-b">
                    <td class="px-4 py-3 font-medium">{{ doc.nomor_dokumen }}</td>
                    <td class="px-4 py-3">{{ doc.judul }}</td>
                    <td class="px-4 py-3">{{ doc.kategori || '-' }}</td>
                    <td class="px-4 py-3">
                      {{ new Date(doc.updated_at).toLocaleString() }}
                    </td>
                    <td class="px-4 py-3">
                      <Link
                        :href="route('documents.open', doc.id)"
                        target="_blank"
                        class="rounded-md bg-green-50 px-3 py-1 text-green-700 hover:bg-green-100"
                      >
                        Buka
                      </Link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- TOP CATEGORY -->
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
          <div class="border-b border-gray-100 p-5">
            <h3 class="text-base font-semibold text-gray-800">Departemen Terbanyak</h3>
            <p class="mt-1 text-sm text-gray-500">Top 8 departemen berdasarkan jumlah dokumen</p>
          </div>

          <div class="p-5">
            <div v-if="!categoryBreakdown.length" class="text-sm text-gray-500">
              Belum ada departemen.
            </div>

            <div v-else class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
              <div
                v-for="row in categoryBreakdown"
                :key="row.kategori"
                class="rounded-lg border border-gray-100 p-4"
              >
                <div class="text-sm font-semibold text-gray-800">
                  {{ row.kategori }}
                </div>
                <div class="mt-2 text-2xl font-semibold text-gray-900">
                  {{ row.total }}
                </div>
                <div class="text-xs text-gray-400">dokumen</div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>
