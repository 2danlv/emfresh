<?php
/**
* Template Name: List-customer
*
* @package WordPress
* @subpackage Twenty_Twelve
* @since Twenty Twelve 1.0
*/

get_header('customer');
// Start the Loop.
// while ( have_posts() ) : the_post();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>List Customer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">List Customer</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Tên đầy đủ</th>
                <th>Số điện thoại</th>
                <th>Tag phân loại</th>
                <th>Điểm tích lũy</th>
              </tr>
              </thead>
              <tbody>
                
                    <?php 
                    $query = new WP_Query(array(
                        'post_type' => 'customer',
                        'post_status' => 'publish'
                    ));
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_id = get_the_ID();
                        $phone = get_post_meta($post_id, 'phone', true);
                        $tag = get_post_meta($post_id, 'tag', true);
                        $point = get_post_meta($post_id, 'point', true);
                        ?>
                        <tr>
                            <td><a href="<?php echo the_permalink(); ?>"> <?php echo the_title(); ?></a></td>
                            <td><?php echo $phone; ?></td>
                            <td><?php echo $tag; ?></td>
                            <td><?php echo $point; ?></td>
                        </tr>
                    <?php }
                    
                    wp_reset_query();
                    ?>
                  
                
                
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        
        <!-- /.card-body -->
        
      </div>
<?php
// endwhile;
get_footer('customer');
