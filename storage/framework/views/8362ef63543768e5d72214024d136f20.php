

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Relatórios</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Relatório de Vendas -->
        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="bg-indigo-600 text-white p-4">
                <h3 class="text-lg font-medium flex items-center">
                    <i class="fas fa-chart-line mr-2"></i> Vendas
                </h3>
            </div>
            <div class="p-4">
                <p class="text-gray-600 mb-4">Relatório detalhado de vendas por período</p>
                <a href="<?php echo e(route('reports.sales')); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                    Acessar Relatório <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        <!-- Relatório de Produtos -->
        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="bg-green-600 text-white p-4">
                <h3 class="text-lg font-medium flex items-center">
                    <i class="fas fa-boxes mr-2"></i> Produtos
                </h3>
            </div>
            <div class="p-4">
                <p class="text-gray-600 mb-4">Análise de estoque e produtos mais vendidos</p>
                <a href="<?php echo e(route('reports.products')); ?>" class="text-green-600 hover:text-green-800 font-medium flex items-center">
                    Acessar Relatório <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        <!-- Relatório de Clientes -->
        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
            <div class="bg-purple-600 text-white p-4">
                <h3 class="text-lg font-medium flex items-center">
                    <i class="fas fa-users mr-2"></i> Clientes
                </h3>
            </div>
            <div class="p-4">
                <p class="text-gray-600 mb-4">Clientes que mais compram e fidelidade</p>
                <a href="<?php echo e(route('reports.clients')); ?>" class="text-purple-600 hover:text-purple-800 font-medium flex items-center">
                    Acessar Relatório <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ['title' => 'Relatórios'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\loja_de_roupa\resources\views/reports/index.blade.php ENDPATH**/ ?>