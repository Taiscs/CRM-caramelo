

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h3>Cadastrar Vendedor</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- Formulário de cadastro -->
    <form action="<?php echo e(route('vendedor.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="nome_consultor" class="form-label">Nome</label>
            <input type="text" name="nome_consultor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="sobrenome_consultor" class="form-label">Sobrenome</label>
            <input type="text" name="sobrenome_consultor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="unidade" class="form-label">Unidade</label>
            <select name="unidade" class="form-select" required>
                <?php $__currentLoopData = $unidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($unidade->ID); ?>"><?php echo e($unidade->NOME); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto do Vendedor</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <hr>

    <!-- Lista de vendedores existentes -->
    <h4 class="mt-4">Vendedores Cadastrados</h4>
    <div class="row">
        <?php $__currentLoopData = $consultores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                   <img src="<?php echo e($consultor->foto ? asset($consultor->foto) : asset('storage/fotos_vendedores/default-avatar.png')); ?>" 
                        class="card-img-top rounded-circle mx-auto mt-3" 
                        style="width: 100px; height: 100px; object-fit: cover;">

                    <div class="card-body">
                        <form action="<?php echo e(route('vendedor.update', $consultor->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <input type="text" name="nome_consultor" class="form-control mb-2" value="<?php echo e($consultor->nome_consultor); ?>" required>
                            <input type="text" name="sobrenome_consultor" class="form-control mb-2" value="<?php echo e($consultor->sobrenome_consultor); ?>" required>

                            <select name="unidade" class="form-select mb-2" required>
                                <?php $__currentLoopData = $unidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($unidade->ID); ?>" <?php echo e($consultor->unidade == $unidade->ID ? 'selected' : ''); ?>>
                                        <?php echo e($unidade->NOME); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <select name="ativo" class="form-select mb-2" required>
                                <option value="1" <?php echo e($consultor->ativo ? 'selected' : ''); ?>>Ativo</option>
                                <option value="0" <?php echo e(!$consultor->ativo ? 'selected' : ''); ?>>Inativo</option>
                            </select>

                            <input type="file" name="foto" class="form-control mb-2">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel_app\resources\views/vendedor/create.blade.php ENDPATH**/ ?>