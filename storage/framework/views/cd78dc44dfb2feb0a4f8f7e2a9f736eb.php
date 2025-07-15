

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Histórico de Estoque: <?php echo e($product->name); ?></h2>
        <a href="<?php echo e(route('products.index')); ?>" class="text-indigo-600 hover:text-indigo-900">
            Voltar para produtos
        </a>
    </div>
    
    <div class="mb-6 bg-gray-50 p-4 rounded-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Estoque Atual</p>
                <p class="text-2xl font-semibold <?php echo e($product->quantity <= $product->min_quantity ? 'text-red-600' : 'text-gray-900'); ?>">
                    <?php echo e($product->quantity); ?>

                </p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Estoque Mínimo</p>
                <p class="text-2xl font-semibold text-gray-900"><?php echo e($product->min_quantity); ?></p>
            </div>
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm font-medium text-gray-500">Status</p>
                <p class="text-2xl font-semibold <?php echo e($product->quantity <= $product->min_quantity ? 'text-red-600' : 'text-green-600'); ?>">
                    <?php echo e($product->quantity <= $product->min_quantity ? 'Baixo Estoque' : 'Normal'); ?>

                </p>
            </div>
        </div>
    </div>
    
    <!-- Formulário de ajuste de estoque -->
    <div class="mb-6 bg-gray-50 p-4 rounded-md">
        <h3 class="text-lg font-medium mb-3">Ajustar Estoque</h3>
        <form action="<?php echo e(route('products.adjust-inventory', $product->id)); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantidade *</label>
                    <input type="number" id="quantity" name="quantity" required min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipo *</label>
                    <select id="type" name="type" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="entrada">Entrada</option>
                        <option value="saida">Saída</option>
                    </select>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Observação</label>
                    <input type="text" id="notes" name="notes"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                    Registrar Ajuste
                </button>
            </div>
        </form>
    </div>
    
    <!-- Tabela de histórico -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observação</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($movement->created_at->format('d/m/Y H:i')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($movement->movement_type === 'entrada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($movement->movement_type === 'entrada' ? 'Entrada' : 'Saída'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo e($movement->movement_type === 'entrada' ? 'text-green-600 font-medium' : 'text-red-600 font-medium'); ?>">
                        <?php echo e($movement->movement_type === 'entrada' ? '+' : '-'); ?><?php echo e($movement->quantity); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($movement->user->name); ?>

                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <?php echo e($movement->notes ?? '-'); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Nenhum movimento registrado
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4">
        <?php echo e($movements->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ['title' => 'Histórico de Estoque'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\loja_de_roupa\resources\views/products/inventory-history.blade.php ENDPATH**/ ?>