## ������������ �� ������ � ���������

�������� ������ ������ �� ������ � ��������� ��.

### ��������� ���� `PRIMARY KEY` � ��������

� ����������� ������� ��� ������ InnoDB � MySQL ����� ����� ������������ ��������� ���� (������) �� ��������� ����.
��� �������� ������ � �������� � �������� ���������� � ������� �� ������. ������� ���������� �����, ����� �������� ������ 
���������� MySQL, ��� ��������� ��� �������� ������� ������� ������.

� ���� ��, MySQL �� ��������� ������� ������� `PRIMARY KEY `, �� � ���� ������ � ��� �� ����� ������� � ����.

�������������  bigint(20) unsigned ���������������.

```sql
CREATE TABLE `b_bx24_url` (
	`ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`DATE_CREATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`URL` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	PRIMARY KEY (`ID`),
	UNIQUE KEY `UX_DBNAME` (`URL`)
) ENGINE=InnoDB AUTO_INCREMENT=20342 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```

��������� ������ ���������� ���������� �� ���� ����, ��� ����� �������� ID ������� ������� ���� ������� ��� ��������.
��� ����������� ������� ���������� ������� �� �������. ���� �� �� ����� ���������� �����, �� �� ������� �����
����������� ������ ��� ������ ������, ��� �� �������� ��� ���������. � ���������� ����, ������ ������ �����������.

������������� ��������� ��������� ������, ����� ���� �� ����������. ��� ��� � ������� ����� ���� �� ��� ���� �����.

### ���������� `PRIMARY KEY` � ��������� �������

��� ������������� ������ InnoDB, �� ���� ��������� `PRIMARY KEY` � ����� ���������� �������. ��������� ���� ������ ��� 
MySQL �� ������ ������ ������� �� ����������� � ������� �� �� ���������.

```sql
KEY `UX_DBNAME` (`URL`, `ID`)
```
��� ��� InnoDB � ����� ������� ������� ��������� ������ �� ��������� ������ � ����������� ���� ������ ������������ �

```sql
KEY `UX_DBNAME` (`URL`, `ID`, `ID`)
```

### ����������� �������� ������� � ������ � �������� ������
��� �������� �������� ��� ����� ���� `TEXT` ��� `VARCHAR` ����� ������������� ����������� ����� ������� ��� ����.
```sql
KEY `UX_DBNAME` (`URL` (32))
```
��� ����� ���� `TEXT` ��� ����������� ����������, � ��� ����� `VARCHAR` ����� �������� ���� � ��� � ���� �����������
����������� ������ ��������, ��� �������� ����� ��������. ��������� ����� ������� ������, ����� �������� ��� ������������� 
�� ���� ���������� ��� �������.

����� ����� �������� �������� �� ���������� �� ������� ���������. ��������, � ���� ������� `service_id` �������� 
� ������� ����� ���� �� 1000 ��������. � ���� ������ ��� ������� ���������� �� �������� ����� ���� ����� �������� 
��� �� ���� � ��������� ����, � �������� ������ ������ �� ��� ����. �� �������� � ����� � ������������ �����.
� ���������� ������������� ������� ���������� �� ���� ���������� ������� �������.

### ������ � ���������� ���������

������� ������� � ��������� ������� ����� � ������ �� ������������� �������. ���������� �� ������� �������.

```sql
KEY `IX_SOME_KEY` (`A`, `B`, `C`)
```

������ ����� �������������� ��������� � ��������:
```sql
A > 9
A = 9 AND B > 6
A = 9 AND B = 15 AND C = 11
A = 9 AND B IN (2,3) AND C > 3
```

������ ����� �������������� ��������:
```sql
A > 9 AND B = 6 -- ����� �������������� ������ �������� �� ������ ������� �������
A = 9 AND B > 15 AND C = 11 -- ����� �������������� ������ ������� � �������� �� ������
```

������ �� ����� ��������������:
```sql
B > 6 -- � ������� ���� ������ ������� �������
B = 15 AND C > 11 -- � ������� ���� ������ ������� �������
```

MySQL ����� ������������ ������, �� ��� ��� ���� ��� � ������� �� ���������� ������� � ���������� (>, <, BETWEEN).
��� ������� ����� ��������� ������������ �������� �� �������. MySQL ������ ���������� ������������ ������� �� �������, 
���� �������� �������� IN (). 

����� ������� ��� �������������� ���������� �������, ���������� ��������� ���� ������� � �������� ��� ����. ��� ������
������, �������� ������ �� ����, ������� ���� � ���������� ���������� ��������.

### ������� � ����������

������������� �������� ����� �������� � ����������. ��������, ��� �������
```sql
SELECT * FROM b_iblock_element ORDER BY SORT DESC LIMIT 10;
```
�������� ������ ����������� ����. 
```sql
KEY `IX_SORT` (`SORT`)
```
���� �� ����� ������� �� �����, �� MySQL ������ ��������� ������ � ������� ����������� (filesort), ��� ������ � ��������.

��� ��������� ������� � ����������� � �����������, ���������� �������������� ��������� ������.
```sql
SELECT * FROM b_iblock_element WHERE IBLOCK_ID = 3 ORDER BY SORT DESC LIMIT 10;
KEY `IX_IBLOCK_SORT` (`IBLOCK_ID`, `SORT`)
```

������� ������������� ������� ��� ���������� � �������� � ���.

```sql
KEY IX_KEY (`A`, `B`)
```
������ **�����** �������������� ��� ����������
```sql
ORDER BY A -- ���������� �� ������ ������� �������
A = 9 ORDER BY B -- ���������� �� ������ ������� � ���������� �� ������
ORDER BY A DESC, B DESC -- ���������� �� ���� ��������, � ����� �����������
A > 9 ORDER BY A DESC -- �������� � ���������� �� ������ �������
```

������ **�� �����** �������������� ��� ���������� 
```sql
ORDER BY B -- ���������� �� ������ ������� �������
A > 9 ORDER BY B DESC -- �������� �� ������, ���������� �� ������
A IN (3,4) ORDER BY B -- in �������� �� ������ �������
ORDER BY A ASC, B DESC -- ���������� �� ���� ��������, � ������ ������������
```

### Join � �������

MySQL ���������� � �������� �������� Nested Loops ��� ������ ������. 

```sql
SELECT * FROM POSTS, COMMENTS WHERE AUTHOR = 15 AND COMMENTS.POST_ID = POSTS.ID
```
���, ��� ���������� ������� ������� �� ������� �������� �� ������� POSTS � ������ ������ � ������� 15. 
� ��� ������ ��������� ������ ������� ������ ��������� ������� COMMENTS, ��� �� ������������ �����������. ����� ������� 
����� ������� ��� ����� ����� �� ������� ������������. � � ������ ������ � ������������ ������ ����� �������������.

������� ��� ���� �������� � Join ���������� ��������� ������� � �������������� �������� �� ��� �����, �� ������� ���� 
�����������.

��� ������� ����, ��� ����� 
```sql

ALTER TABLE COMMENTS ADD INDEX IX_POST_ID (POST_ID); -- ������������ ������ ��� Join 
ALTER TABLE POSTS ADD INDEX ID_AUTHOR (AUTHOR); -- ������ ��� ��������� ���������� ������� � ������ �������.
```
��� ���� ������ �� POSTS.ID � ������ ������, ��� ��������� ��������, �� �����. �� ��� Join ����� ��������� ������� 
������ � MySQL ������ ����������� ������� �� ������� �� Join, � ����� ��� �� ��������. � ���� ������ ��������� ������ � 
� �������� �������. ( ��� �������� ������ �������� �� POST.ID, ������� ��� ��� �� PK )