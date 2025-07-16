

<?php $__env->startSection('title', 'Logs de Atividade'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Logs de Atividade</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="filterDropdown" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter fa-sm fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                     aria-labelledby="filterDropdown">
                    <form class="px-4 py-3" method="GET">
                        <div class="form-group">
                            <label for="user_id">Usuário</label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" 
                                        <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="event">Evento</label>
                            <select class="form-control" id="event" name="event">
                                <option value="">Todos</option>
                                <option value="created" <?php echo e(request('event') == 'created' ? 'selected' : ''); ?>>Criação</option>
                                <option value="updated" <?php echo e(request('event') == 'updated' ? 'selected' : ''); ?>>Atualização</option>
                                <option value="deleted" <?php echo e(request('event') == 'deleted' ? 'selected' : ''); ?>>Remoção</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="model_type">Modelo</label>
                            <select class="form-control" id="model_type" name="model_type">
                                <option value="">Todos</option>
                                <option value="Product" <?php echo e(request('model_type') == 'Product' ? 'selected' : ''); ?>>Produtos</option>
                                <option value="Sale" <?php echo e(request('model_type') == 'Sale' ? 'selected' : ''); ?>>Vendas</option>
                                <option value="Client" <?php echo e(request('model_type') == 'Client' ? 'selected' : ''); ?>>Clientes</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Data/Hora</th>
                            <th>Usuário</th>
                            <th>Ação</th>
                            <th>Modelo</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($log->created_at->format('d/m/Y H:i')); ?></td>
                            <td><?php echo e($log->user->name); ?></td>
                            <td>
                                <?php if($log->event == 'created'): ?>
                                    <span class="badge badge-success">Criado</span>
                                <?php elseif($log->event == 'updated'): ?>
                                    <span class="badge badge-primary">Atualizado</span>
                                <?php elseif($log->event == 'deleted'): ?>
                                    <span class="badge badge-danger">Removido</span>
                                <?php else: ?>
                                    <span class="badge badge-info"><?php echo e($log->event); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(class_basename($log->model_type)); ?> #<?php echo e($log->model_id); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.activity-logs.show', $log)); ?>" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum registro encontrado</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($logs->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Herd\loja_de_roupa\resources\views/admin/activity-logs/index.blade.php ENDPATH**/ ?>