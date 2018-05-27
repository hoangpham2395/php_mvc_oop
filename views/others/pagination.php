<?php
$last = ceil($pagination['total'] / $pagination['limit']);
$start = ($pagination['page'] - $pagination['links'] > 0) ? $pagination['page'] - $pagination['links'] : 1;
$end = ($pagination['page'] + $pagination['links'] < $last) ? $pagination['page'] + $pagination['links'] : $last;

$name = (!empty($pagination['termSearch']['name'])) ? $pagination['termSearch']['name'] : '';
$email = (!empty($pagination['termSearch']['email'])) ? $pagination['termSearch']['email']: '';
$search = (!empty($pagination['termSearch'])) ? '&name='.$name.'&email='.$email : '';

$row = (!empty($pagination['termSort']['row'])) ? $pagination['termSort']['row'] : '';	
$arrange = (!empty($pagination['termSort']['arrange'])) ? $pagination['termSort']['arrange'] : '';
$sort = (!empty($pagination['termSort'])) ? '&row='.$row.'&arrange='.$arrange : '';

$html = '<ul class="pagination pull-right" >';
$class = ($pagination['page'] == 1) ? 'disabled' : '';
$html .= '<li class="'.$class.'" ><a href="index.php?c='.$pagination['table'].'&a=index'.$search.$sort.'&limit='.$pagination['limit'].'&page='.($pagination['page'] - 1).'">&laquo;</a>';
 if ( $start > 1 ) {
    $html .= '<li><a href="index.php?c='.$pagination['table'].'&a=index'.$search.$sort.'&limit='.$pagination['limit'].'&page=1">1</a></li>';
    $html .= '<li class="disabled"><span>...</span></li>';
}

for ( $i = $start ; $i <= $end; $i++ ) {
    $class = ( $pagination['page'] == $i ) ? "active" : "";
    $html .= '<li class="'.$class.'"><a href="index.php?c='.$pagination['table'].'&a=index'.$search.$sort.'&limit='.$pagination['limit'].'&page='.$i.'">'.$i.'</a></li>';
}

if ( $end < $last ) {
    $html .= '<li class="disabled"><span>...</span></li>';
    $html .= '<li><a href="index.php?c='.$pagination['table'].'&a=index'.$search.$sort.'&limit='.$pagination['limit'].'&page='.$last.'">'.$last.'</a></li>';
}

$class = ( $pagination['page'] == $last ) ? "disabled" : "";
$last_index = ($pagination['page'] == $last) ? $last : ($pagination['page'] + 1);
$html .= '<li class="'.$class.'"><a href="index.php?c='.$pagination['table'].'&a=index'.$search.$sort.'&limit='.$pagination['limit'].'&page='.$last_index.'">&raquo;</a></li>';

$html .= '</ul>';

echo $html;
?>