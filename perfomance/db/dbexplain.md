## ������������ explain ��������

��� ������� ����� ���������� �������� � ��������� ������� � MySQL ���������� ������� EXPLAIN. �� ������ ���������� �� 
�������.

�������
```sql
CREATE TABLE `b_iblock_element` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IBLOCK_ID` int(11) NOT NULL DEFAULT '0',
  `IBLOCK_SECTION_ID` int(11) DEFAULT NULL,
  `SORT` int(11) NOT NULL DEFAULT '500',
  `NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `WF_PARENT_ELEMENT_ID` int(11) DEFAULT NULL,
  `XML_ID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `WF_LAST_HISTORY_ID` int(11) DEFAULT NULL,
  `SHOW_COUNTER` int(18) DEFAULT NULL,
  `SHOW_COUNTER_START` datetime DEFAULT NULL,
  
  PRIMARY KEY (`ID`),
  KEY `ix_iblock_element_1` (`IBLOCK_ID`,`IBLOCK_SECTION_ID`),
  KEY `ix_iblock_element_4` (`IBLOCK_ID`,`XML_ID`,`WF_PARENT_ELEMENT_ID`),
  KEY `ix_iblock_element_3` (`WF_PARENT_ELEMENT_ID`),
  KEY `bx_perf_001` (`NAME`,`IBLOCK_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1318928 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```

```sql
EXPLAIN
SELECT * FROM b_iblock_element WHERE ACTIVE = 'Y' AND NAME LIKE 'rns%';
```
��������, ����������� ���� ������, �� ������� ��������� ���������
![������ �������� EXPLAIN](../img/explain_1.png)

#### selected_type ��� ������� � �������

���������� ��� ������� SELECT ��� ������ ������ ���������� EXPLAIN. ���� ������ ������� � �� �������� ����������� ���
�����������, �� � ������� ����� �������� `SIMPLE`. �����, ����� ������� ������ ���������� ��� `PRIMARY`, � ��������� 
��������� �������:

* `SUBQUERY` ������ `SELECT`, ������� ���������� � ����������, ����������� � ������� SELECT (�.�. �� � ������� FROM).

* `DERIVED` ���������� ����������� �������, ���������� ����������� � ������� `FROM`. ����������� ���������� � 
���������� �� ��������� �������, �� ������� ������ ��������� �� ����� `derived table`.

* `UNION` ���� ������������ ����������� `UNION`, �� ������ �������� � ���� ������ ��������� ������ �������� ������� �
���������� ��� `PRIMARY`. ���� �� ����������� `UNION` ���� ������ ���������� � ������� `FROM`, �� ��� ������ ������ `SELECT`
��� �� ������� ��� `DERIVED`. ������ � ����������� ������� ���������� ��� `UNION`.

* `UNION RESULT` ���������� ���������� ������� `SELECT`, ������� ������ MySQL ��������� ��� ������ �� ��������� �������,
��������� � ���������� ����������� `UNION`.

* `DEPENDENT` ������ ����� ����� ���� �������� `SUBQUERY`, `UNION` � `DERIVED`, �� ���� ��������� ������� ������� �� ������,
�������� �������.

* `MATERIALIZED` ������������� ��������� ������� ��� ����������� ������ ����������� � [NOT] IN, ��������� ���������
��������� ������ ���� ���, ��� ���� ����� �������� �������.

* `UNCACHEABLE SUBQUERY` | `UNCACHEABLE UNION` ��������� �� ����� ���� ��������� � ������ ����������� ��� ������ ������


####table - ������� ������������ � �������

####type - ��� ����������� ������
���������� ��� ������������� ����������� ������, ���� �������� ������ ���� ����������, ������������� �� ���������� ���� 
� �������:

* `system` ������� �������� ������ ���� ������ (= ��������� �������). ������� ������ ���� `const join`.
* `const` ������� �������� �� ����� ����� ����������� ������. ������� �������� ������� �� ������ ���� �������, ����� 
��������������� ��������� ������ ������������ ��� ���������. ������ ��� ����������� �������� ����� ������, ��� ��� 
������ ����������� ������ ���� ���.
`const` ������������, ��� ��������� `PRIMARY KEY` ��� `UNIQUE INDEX` � ���������� ���������.
```sql
SELECT * FROM table WHERE PRIMARY_KEY = 1;

SELECT * FROM table WHERE PRIMARY_KEY_PART1 = 1 AND PRIMARY_KEY_PART2 = 2;
```
* `eq_ref` ��� ������ ���������� ����� �� ���������� ������ ����������� ���� ������. ���������� ��� ������ ��������� �
`PRIMARY_KEY` ��� �� ������� `UNIQUE KEY`.

����� �������������� ��� ��������������� ��������, ������� ������������ � ������� ��������� =. �������� ��������� ����� ���� ���������� ��� ����������, ������������ ������� �� ������, ������� ����������� ����� ���� ��������. � ��������� �������� MySQL ����� ������������ ���������� eq_ref ��� ��������� ref_table:


* 
* possible_keys - ��������� �����, ��� ������� �������
* key - ���� ��������� �������������, ��� ���������� �������
* key_len - ����� �����
* ref - ������������ ������ ��� ���������� �� �������� ������ ������
* rows - ���������� �����, ������� �������� mysql, ��� ���������� ������� (��� ������ ��� �����)
* Extra - �������������� ���������� �� ����� ���������� �������

�� ������������ ��������� �����, ��� ������ � ����� �����������, ��� ��� �������������� ����� 5 ����� � �������������
������. �� ���� ���������� �� ������� Extra �����, ��� ������ �������, ���������� �������� ����������� ���������
� ���������� ������. ����� ������� ��� ������������ ������ ������ ������ ����� ��������� �� �����������.

��� ����� ���������� �� ��������� �������������, ����� ������������ explain � json �������.

```sql
EXPLAIN format = json
SELECT * FROM b_iblock_element WHERE ACTIVE = 'Y' AND NAME LIKE 'rns%';
```
� ���� ������ �� �������, ��������� ���������
```json
{
  "query_block": {
    "select_id": 1,
    "table": {
      "table_name": "b_iblock_element",
      "access_type": "range",
      "possible_keys": ["bx_perf_001"],
      "key": "bx_perf_001",
      "key_length": "767",
      "used_key_parts": ["NAME"],
      "rows": 5,
      "filtered": 100,
      "index_condition": "(b_iblock_element.`NAME` like 'rns%')",
      "attached_condition": "(b_iblock_element.ACTIVE = 'Y')"
    }
  }
}
```
�� �������� �����, ��� �� ���������� ������� �������������� ������ ���� ���� `NAME`. � ������, ���������� ��������
��������� ����������� � �������� `(b_iblock_element.ACTIVE = 'Y')`.