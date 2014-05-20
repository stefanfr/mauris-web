<div itemscope itemtype="http://schema.org/EmailMessage">
<h1>Feedback</h1>

    <meta itemprop="description" content="<?=__('View the feedback at the system')?>"/>
    <div itemprop="action" itemscope itemtype="http://schema.org/ViewAction">
        <link itemprop="url" href="<?=Router::url(array('controller' => 'feedback', 'action' => 'view', $id), true)?>"/>
        <meta itemprop="name" content="<?=__('View feedback')?>"/>
    </div>
    
    <table>
        <tr>
            <th>User</th>
            <td><?=($user) ? $user['username'] : 'Unknown'?></td>
        </tr>
        <tr>
            <th>School</th>
            <td><?=($school_name)?></td>
        </tr>
        <tr>
            <th>Department</th>
            <td><?=($department_name)?></td>
        </tr>
        <tr>
            <th>Body</th>
            <td><?=$data['Feedback']['body']?></td>
        </tr>
    </table>
</div>