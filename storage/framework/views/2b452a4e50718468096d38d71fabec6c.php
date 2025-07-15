

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
        <h2 class="text-2xl font-semibold">Gerenciamento de Clientes</h2>
        
        <a href="<?php echo e(route('clients.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
            <i class="fas fa-plus mr-2"></i> Novo Cliente
        </a>
    </div>
    
    <!-- Filtros -->
    <form method="GET" action="<?php echo e(route('clients.index')); ?>" class="mb-6">
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Pesquisar</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>"
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                           placeholder="Pesquisar por nome, email ou telefone">
                </div>
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Filtrar
            </button>
            <a href="<?php echo e(route('clients.index')); ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Limpar
            </a>
        </div>
    </form>
    
    <!-- Tabela de Clientes -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contato</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compras</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Gasto</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Compra</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($client->name); ?></div>
                                <?php if($client->cpf): ?>
                                    <div class="text-sm text-gray-500">CPF: <?php echo e($client->cpf); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo e($client->email); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e($client->phone); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($client->purchases_count); ?> compras
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        R$ <?php echo e(number_format($client->total_spent, 2, ',', '.')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($client->last_purchase ? \Carbon\Carbon::parse($client->last_purchase)->format('d/m/Y') : 'Nunca comprou'); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="<?php echo e(route('clients.show', $client->id)); ?>" class="text-indigo-600 hover:text-indigo-900" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('clients.edit', $client->id)); ?>" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('clients.destroy', $client->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Nenhum cliente encontrado
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4">
        <?php echo e($clients->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ['title' => 'Clientes'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\loja_de_roupa\resources\views/clients/index.blade.php ENDPATH**/ ?>