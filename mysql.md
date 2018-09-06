#mysql 8.0 sql新特性

###分析函数（窗口函数）

1.  rank() over (partition by '分区语句') 
    row_number()
    DENSE_RANK()

   例子：select * from (select row_number()over(partition by subject order by score desc) as rn,id,name,subject,score  from window_test )t where rn=1;

###公用表表达式 CTE

>   with ctetest as (select * from window_test where id=1) select * from ctetest;

>   递归查询  重复调用cte


### 