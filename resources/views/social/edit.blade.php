@extends('layouts.app', ['title' => 'Editar Post'])

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <h2 class="text-2xl font-semibold mb-6">Editar Post</h2>
    
    <form action="{{ route('social.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="platform" class="block text-sm font-medium text-gray-700">Plataforma *</label>
                <select id="platform" name="platform" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="instagram" {{ $post->platform === 'instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="facebook" {{ $post->platform === 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="twitter" {{ $post->platform === 'twitter' ? 'selected' : '' }}>Twitter</option>
                    <option value="tiktok" {{ $post->platform === 'tiktok' ? 'selected' : '' }}>TikTok</option>
                </select>
            </div>
            
            <div>
                <label for="post_type" class="block text-sm font-medium text-gray-700">Tipo de Post *</label>
                <select id="post_type" name="post_type" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="post" {{ $post->post_type === 'post' ? 'selected' : '' }}>Post</option>
                    <option value="story" {{ $post->post_type === 'story' ? 'selected' : '' }}>Story</option>
                    <option value="reel" {{ $post->post_type === 'reel' ? 'selected' : '' }}>Reel</option>
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                <select id="status" name="status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Rascunho</option>
                    <option value="scheduled" {{ $post->status === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                    <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Publicado</option>
                </select>
            </div>
            
            <div id="publish-at-field" style="{{ $post->status !== 'scheduled' ? 'display: none;' : '' }}">
                <label for="publish_at" class="block text-sm font-medium text-gray-700">Data de Publicação *</label>
                <input type="datetime-local" id="publish_at" name="publish_at" 
                       value="{{ $post->publish_at ? $post->publish_at->format('Y-m-d\TH:i') : '' }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Imagem</label>
                <input type="file" id="image" name="image" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                @if($post->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Imagem atual" class="h-32 rounded-md">
                    </div>
                @endif
            </div>
            
            <div>
                <label for="caption" class="block text-sm font-medium text-gray-700">Legenda *</label>
                <textarea id="caption" name="caption" rows="4" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $post->caption }}</textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('social.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusField = document.getElementById('status');
    const publishAtField = document.getElementById('publish-at-field');
    
    statusField.addEventListener('change', function() {
        if (this.value === 'scheduled') {
            publishAtField.style.display = 'block';
        } else {
            publishAtField.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection