@extends('layouts.app', ['title' => 'Novo Post'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Criar Novo Post</h2>
    
    <form action="{{ route('social.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Coluna 1 -->
            <div class="space-y-4">
                <div>
                    <label for="platform" class="block text-sm font-medium text-gray-700">Plataforma *</label>
                    <select id="platform" name="platform" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Selecione uma plataforma</option>
                        <option value="instagram">Instagram</option>
                        <option value="facebook">Facebook</option>
                        <option value="twitter">Twitter</option>
                        <option value="tiktok">TikTok</option>
                    </select>
                    @error('platform')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="post_type" class="block text-sm font-medium text-gray-700">Tipo de Post *</label>
                    <select id="post_type" name="post_type" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Selecione um tipo</option>
                        <option value="post">Post</option>
                        <option value="story">Story</option>
                        <option value="reel">Reel</option>
                    </select>
                    @error('post_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                    <select id="status" name="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Selecione um status</option>
                        <option value="draft">Rascunho</option>
                        <option value="scheduled">Agendado</option>
                        <option value="published">Publicado</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div id="publishAtField" class="hidden">
                    <label for="publish_at" class="block text-sm font-medium text-gray-700">Data de Publicação *</label>
                    <input type="datetime-local" id="publish_at" name="publish_at"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('publish_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Coluna 2 -->
            <div class="space-y-4">
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagem *</label>
                    <input type="file" id="image" name="image" accept="image/*" required
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="caption" class="block text-sm font-medium text-gray-700">Legenda *</label>
                    <textarea id="caption" name="caption" rows="5" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    @error('caption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('social.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Salvar Post
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const publishAtField = document.getElementById('publishAtField');
    
    statusSelect.addEventListener('change', function() {
        if (this.value === 'scheduled') {
            publishAtField.classList.remove('hidden');
            
            // Set minimum datetime to now
            const now = new Date();
            const timezoneOffset = now.getTimezoneOffset() * 60000;
            const localISOTime = (new Date(now - timezoneOffset)).toISOString().slice(0, 16);
            document.getElementById('publish_at').min = localISOTime;
        } else {
            publishAtField.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection