

<?php $__env->startSection('title', 'Lixeira'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Lixeira</h1>
    
    <?php $__currentLoopData = ['clients', 'products', 'sales', 'suppliers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 capitalize"><?php echo e(str_replace('_', ' ', $model)); ?> Excluídos</h2>
            
            <?php if(isset($trashedItems[$model])): ?>
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Excluído em</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $trashedItems[$model]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($item->id); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo e($item->name ?? $item->title ?? $item->invoice_number ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($item->deleted_at)->format('d/m/Y H:i')); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <form action="<?php echo e(route('trash.restore', [$model, $item->id])); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restaurar</button>
                                    </form>
                                    <span>|</span>
                                    <form action="<?php echo e(route('trash.destroy', [$model, $item->id])); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Tem certeza que deseja excluir permanentemente?')">
                                            Excluir Permanentemente
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
            <?php else: ?>
                <p class="text-gray-500 mb-8">Nenhum item na lixeira</p>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\loja_de_roupa\resources\views/trash/index.blade.php ENDPATH**/ ?>