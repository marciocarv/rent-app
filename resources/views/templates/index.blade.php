<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-blue-900">
                Meus Modelos de Contrato
            </h2>
            <a href="{{ route('templates.create') }}" class="px-4 py-2 text-sm font-bold text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-500">
                + Novo Modelo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-xl">
                @if($templates->isEmpty())
                    <div class="p-8 text-center text-slate-500">
                        <p class="mb-4">Você ainda não possui nenhum modelo de contrato salvo.</p>
                        <form action="{{ route('templates.defaults') }}" method="POST">
                            @csrf
                            <button type="submit" class="font-bold text-blue-600 hover:underline">
                                Gerar Modelos Padrão Automaticamente
                            </button>
                        </form>
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-sm border-b bg-slate-50 text-slate-600 border-slate-200">
                                <th class="p-4 font-bold">Nome do Modelo</th>
                                <th class="p-4 font-bold">Última Atualização</th>
                                <th class="p-4 font-bold text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($templates as $template)
                                <tr class="transition-colors hover:bg-slate-50">
                                    <td class="p-4 font-medium text-slate-800">{{ $template->name }}</td>
                                    <td class="p-4 text-sm text-slate-500">{{ $template->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="flex items-center justify-end gap-3 p-4 text-right">

                                        <!-- Edit Button -->
                                        <a href="{{ route('templates.edit', $template) }}" class="text-sm font-bold transition-colors text-amber-500 hover:text-amber-700" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('templates.destroy', $template) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este modelo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-bold text-red-500 transition-colors hover:text-red-700" title="Excluir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
