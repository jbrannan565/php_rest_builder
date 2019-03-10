import os
from db_config import db
from setup import meta

def build_model(table):
    with open('./templates/entities/base.php', "r") as t:
        create_template = "".join(t.readlines())
        _vars = ""
        _valVars = ""
        _vals = ""
        _conds = ""
        _sets = ""
        for c in table.c:
            if str(c.name) != "id":
                _vars += "\tpublic $%s;\n" % c.name
                _valVars += "%s, " % c.name

                if str(c.type) != "INTEGER" and str(c.type) != "FLOAT":
                    _vals += "\"'\" . addslashes($this->%s) . \"', \" . " % c.name
                else:
                    _vals += "\"\" . $this->%s . \", \" . " % c.name

                _conds += "\t\t\t\tif (!$this->%s) {\n" % c.name
                _conds += "\t\t\t\t\t$this->%s = $%s;\n" % (c.name, c.name)
                _conds += "\t\t\t\t}\n"

                if str(c.type) != "INTEGER" and str(c.type) != "FLOAT":
                    _sets += "\"%s='\" . addslashes($this->%s) . \"', \" . " % (c.name, c.name)
                else:
                    _sets += "\"%s=\" . $this->%s . \", \" . " % (c.name, c.name)

        _valVars = _valVars[:-2]
        _vals = _vals[:-6] + "\" . "
        _sets = _sets[:-6] + "\""

        template = create_template % (
                str(table.name.capitalize()),
                str(table),
                str(_vars),
                str(_valVars),
                str(_vals),
                str(_conds),
                str(_sets)
                )
        with open('./output/entities/%s.php' % table.name, "w+") as o:
            o.write(template)
        print("/entities/%s.php created " % table.name)

def build_create(table):
    with open('./templates/create.php', "r") as c:
        create_template = "".join(c.readlines())
        _vars = ""
        _conds = ""
        _missing = ""
        for c in table.c:
            if str(c.name) != "id":
                _vars += "$%s->%s = $data->%s;\n" % (table.name, c.name, c.name)
                _conds += "!$%s->%s ||" % (table.name, c.name)
                _missing += "%s, " % (c.name)

        _conds = _conds[:-3]
        _missing = _missing[:-2]

        template = create_template % (
                str(table.name),
                str(table.name),
                str(table.name),
                # FIRST LETTER TO CAPS
                str(table.name.capitalize()),
                str(_vars),
                str(_conds),
                str(_missing),
                str(table.name),
                str(table.name),
                str(table.name)
                )
        with open('./output/%s/create.php' % table.name, "w+") as o:
            o.write(template)
        print("/%s/create.php created " % table.name)

def build_read(table):
    with open('./templates/read.php', "r") as c:
        create_template = "".join(c.readlines())
        _vars = ""
        for c in table.c:
            if "INTEGER" in str(c.type):
                _vars += '\t\t"%s" => intval($%s),\n' % (c.name, c.name)
            elif "FLOAT" in str(c.type):
                _vars += '\t\t"%s" => floatval($%s),\n' % (c.name, c.name)
            else:
                _vars += '\t\t"%s" => $%s,\n' % (c.name, c.name)
        _vars = _vars[:-2]

        template = create_template % (
                str(table.name),
                str(table.name),
                # FIRST LETTER TO CAPS
                str(table.name.capitalize()),
                str(table.name),
                str(table.name),
                str(_vars),
                )
        with open('./output/%s/read.php' % table.name, "w+") as o:
            o.write(template)
    print("/%s/read.php created " % table.name)

def build_update(table):
    with open('./templates/update.php', "r") as c:
        create_template = "".join(c.readlines())
        _vars = ""
        for c in table.c:
            if "id" != str(c.name):
                _vars += '$%s->%s = $data->%s;\n' % (table.name, c.name, c.name)
        template = create_template % (
                str(table.name),
                str(table.name),
                str(table.name.capitalize()),
                str(table.name),
                str(_vars),
                str(table.name),
                str(table.name),
                str(table.name)
                )
        with open("./output/%s/update.php" % table.name, "w+") as o:
            o.write(template)
    print("/%s/update.php created " % table.name)

def build_delete(table):
    with open('./templates/delete.php', "r") as c:
        create_template = "".join(c.readlines())
        template = create_template % (
                str(table.name),
                str(table.name),
                str(table.name),
                # FIRST LETTER TO CAPS
                str(table.name.capitalize()),
                str(table.name),
                str(table.name),
                str(table.name),
                str(table.name)
                )
        with open('./output/%s/delete.php' % table.name, "w+") as o:
            o.write(template)
        print("/%s/delete.php created " % table.name)


if __name__ == '__main__':
    os.mkdir('output/entities')
    for t in meta.sorted_tables:
        os.mkdir('output/%s' % t.name)
        build_model(t)
        build_create(t)
        build_read(t)
        build_update(t)
        build_delete(t)

    meta.create_all(db.engine)
