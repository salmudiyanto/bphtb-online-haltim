<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    v-for="(col, index) in columns"
                                    :key="index"
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    {{ col.label || col }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="!rows || rows.length === 0">
                                <td :colspan="columns.length" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <slot name="empty">Data tidak ditemukan.</slot>
                                </td>
                            </tr>
                            <tr v-for="(row, rowIndex) in rows" :key="rowIndex">
                                <td
                                    v-for="(col, colIndex) in columns"
                                    :key="colIndex"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                >
                                    <slot :name="`cell-${col.key}`" :row="row" :value="row[col.key]">
                                        {{ row[col.key] }}
                                    </slot>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BaseTable',
    props: {
        columns: {
            type: Array,
            required: true // Format: [{ key: 'id', label: 'ID' }, { key: 'name', label: 'Nama' }]
        },
        rows: {
            type: Array,
            default: () => []
        }
    }
}
</script>
