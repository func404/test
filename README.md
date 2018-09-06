# test
一些测试文件及学习
test.php  php设计模式的学习

##mysql处理 

1.为查询缓存优化你的查询，开启mysql的查询缓存，不要在常用语句中使用sql的内置函数
2. EXPLAIN 你的 SELECT 查询，查找优化空间
3. 尽量少的从mysql中获取信息
4. 为搜索字段添加索引
5. 在Join表的时候使用相当类型的例，并将其索引
6. 使用合适的数据类型
7. 尽可能的使用 NOT NULL
8. 查询次数比较多的使用预处理语句  Prepared Statements
9. ip地址  ip2long(gethostbyname('weilaixiansen.com'));  //ip的转换
10. 拆分大的 DELETE 或 INSERT 语句
11. 垂直分割表，表的字段不要太多
12. 小心使用永久链接
13. 使用对象关系映射
14. 要创建适当的存储过程，函数，触发器，索引等。
15. 读写分离
16. 


php处理并发的思路

简单来说 就是两个思路：
1.让同时并发数量降下来
2.让同时处理效率升上去

#######一、几个基础概念
1.QPS  (每秒查询率) : 每秒钟请求或者查询的数量
2.PV（Page View）：一个网站所有的页面，在24小时内被访问的总的次数。千万级别，百万级别
3.TPS（吞吐量）：每秒钟处理完的事务次数，一般TPS是对整个系统来讲的。
4.RT：响应时间，处理一次请求所需要的平均处理时间
5.PV（Page View）：综合浏览量，即页面浏览量或者点击量，一个访客在24小时内访问的页面数量
6.UV(独立访客)：一定时间范围内，相同访客多次访问网站，只计算为1个独立访客


###### 二、几个思路

1.用额外的单进程处理一个队列，下单请求放到队列里，一个个处理，就不会有并发的问题了，但是要额外的后台进程以及延迟问题，不予考虑。
2.数据库乐观锁，大致的意思是先查询库存，然后立马将库存+1，然后订单生成后，在更新库存前再查询一次库存，看看跟预期的库存数量是否保持一致，不一致就回滚，提示用户库存不足。
3.根据update结果来判断，我们可以在sql2的时候加一个判断条件update ... where 库存>0，如果返回false，则说明库存不足，并回滚事务。
4.借助文件排他锁，在处理下单请求的时候，用flock锁定一个文件，如果锁定失败说明有其他订单正在处理，此时要么等待要么直接提示用户"服务器繁忙"



处理大流量的几个思路

1.防止我们的网站资源被盗链。（可以采用一些非技术手段防止被盗链，在图片上添加水印）
2.减少http请求
3.启用压缩 减少数据传输的数据量，常见的压缩格式是：gzip,deflate.
4.通过浏览器缓存数据内容。
5.可以把比较占用流量的一些资源，单独组建一个服务器， 比如图片服务器，视频服务器等。

大存储解决方案
1.通过缓存技术，达到不查询数据库或者少查询数据库的目的。   内存》硬盘文件》数据库 
2.图片服务器分离
3.数据库集群和库表散列
4.