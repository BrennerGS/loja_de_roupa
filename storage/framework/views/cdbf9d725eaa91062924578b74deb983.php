

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Detalhes do Cliente</h2>
        <div class="flex space-x-2">
            <a href="<?php echo e(route('clients.edit', $client->id)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <a href="<?php echo e(route('clients.index')); ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Informações Pessoais -->
        <div class="bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium mb-3">Informações Pessoais</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Nome:</span> <?php echo e($client->name); ?></p>
                <?php if($client->cpf): ?>
                    <p><span class="font-medium">CPF:</span> <?php echo e($client->cpf); ?></p>
                <?php endif; ?>
                <?php if($client->birth_date): ?>
                    <p><span class="font-medium">Data Nasc.:</span> <?php echo e(\Carbon\Carbon::parse($client->birth_date)->format('d/m/Y')); ?></p>
                    <p><span class="font-medium">Idade:</span> <?php echo e(\Carbon\Carbon::parse($client->birth_date)->age); ?> anos</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Contato -->
        <div class="bg-gray-50 p-4 rounded-md">
            <h3 class="font-medium mb-3">Contato</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Telefone:</span> <?php echo e($client->phone); ?></p>
                <p><span class="font-medium">Email:</span> <?php echo e($client->email ?? '-'); ?></p>
                <?php if($client->address): ?>
                    <p><span class="font-medium">Endereço:</span> <?php echo e($client->address); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Histórico de Compras -->
    <div>
        <h3 class="text-lg font-medium mb-3">Histórico de Compras</h3>
        <div class="bg-gray-50 p-4 rounded-md mb-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm font-medium text-gray-500">Total de Compras</p>
                    <p class="text-2xl font-semibold text-gray-900"><?php echo e($client->purchases_count); ?></p>
                </div>
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm font-medium text-gray-500">Valor Total Gasto</p>
                    <p class="text-2xl font-semibold text-green-600">R$ <?php echo e(number_format($client->total_spent, 2, ',', '.')); ?></p>
                </div>
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm font-medium text-gray-500">Ticket Médio</p>
                    <p class="text-2xl font-semibold text-blue-600">R$ <?php echo e($client->purchases_count > 0 ? number_format($client->total_spent / $client->purchases_count, 2, ',', '.') : '0,00'); ?></p>
                </div>
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm font-medium text-gray-500">Última Compra</p>
                    <p class="text-2xl font-semibold text-purple-600"><?php echo e($client->last_purchase ? \Carbon\Carbon::parse($client->last_purchase)->format('d/m/Y') : 'Nunca'); ?></p>
                </div>
            </div>
        </div>

        <?php if($client->sales->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Venda</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Itens</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $client->sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($sale->created_at->format('d/m/Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($sale->invoice_number); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($sale->items->sum('quantity')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                R$ <?php echo e(number_format($sale->total, 2, ',', '.')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?php echo e(route('sales.show', $sale->id)); ?>" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="bg-gray-50 p-4 rounded-md text-center text-gray-500">
                Este cliente ainda não realizou nenhuma compra
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ['title' => 'Detalhes do Cliente'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\loja_de_roupa\resources\views/clients/show.blade.php ENDPATH**/ ?>