interface ITables {
    tableName : string
    primaryKey : string
    createdAt : string

    draw : () => void
}

interface IColumn 
{
    columnName : string
    columnType : string
    columnLength : number
    isPrimaryKey : boolean
    isForeignKey : boolean
}