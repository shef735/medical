

function getBooleanValue(cssSelector) {
    return document.querySelector(cssSelector).checked === true;
}

function onBtExport() {
    var params = {
      
        fileName: document.querySelector('#fileName').value,
        sheetName: document.querySelector('#sheetName').value
    };

    gridOptions.api.exportDataAsExcel(params);
}
 

var gridOptions = {
   
   
   
    rowData: rowData,
    columnDefs: columnDefs,
	groupIncludeFooter: false,
  groupIncludeTotalFooter: true,
  animateRows: true,
  
	
	floatingFilter:true,
	enableSorting: true,
    suppressAggFuncInHeader: true,
     sideBar: {
    toolPanels: [
            {
                id: 'columns',
                labelDefault: 'Columns',
                labelKey: 'columns',
                iconKey: 'columns',
                toolPanel: 'agColumnsToolPanel',
                toolPanelParams: {
                    suppressValues: true,
                    suppressPivots: true,
                    suppressPivotMode: true,
                    suppressRowGroups: false
                }
            },
            {
                id: 'filters',
                labelDefault: 'Filters',
                labelKey: 'filters',
                iconKey: 'filter',
                toolPanel: 'agFiltersToolPanel',
            }
        ],
        defaultToolPanel: ''
    },
    rowGroupPanelShow: 'always',
    enableColResize: true,
//    animateRows: true,
  //  groupDefaultExpanded: -1,
  
  onColumnResized: function(params) {
        console.log(params);
    },
	components:{
        boldRenderer: function(params) {
            return '<b>' + params.value.name + '</b>';
        }
    },
	
  defaultColDef: {
    flex: 1,
    sortable: true,
    pinnedRowCellRenderer: 'customPinnedRowRenderer',
    pinnedRowCellRendererParams: {
      style: { color: 'yellow', fontWeight: 'bold'},
    },
  },
  
  getRowStyle: (params) => {
      if (params.node.footer) {
        return { fontWeight: 'bold', background: 'yellow'};
      }
    },
	
	
  

    columnTypes: {
        'numberValue': {
            enableValue: true, 
			aggFunc: 'sum', 
			editable: false, 
			valueParser: 'Number(newValue)',
        },
        'dimension': {
            enableRowGroup: true, enablePivot: true
        }
    }
	
    
	
};


function expandAll() {
    gridOptions.api.expandAll();
}

function collapseAll() {
    gridOptions.api.collapseAll();
}



function numberParser(params) {
	
	return parseFloat(params.newValue);
	
}

function sizeToFit() {
    gridOptions.api.sizeColumnsToFit();
}


function autoSizeAll() {
    var allColumnIds = [];
    gridOptions.columnApi.getAllColumns().forEach(function(column) {
        allColumnIds.push(column.colId);
    });
    gridOptions.columnApi.autoSizeColumns(allColumnIds);
}


function onFilterTextBoxChanged() {
    gridOptions.api.setQuickFilter(document.getElementById('filter-text-box').value);
}

function onPrintQuickFilterTexts() {
    gridOptions.api.forEachNode(function(rowNode, index) {
        console.log('Row ' + index + ' quick filter text is ' + rowNode.quickFilterAggregateText);
    });
}

function onQuickFilterTypeChanged() {
    var rbCache = document.querySelector('#cbCache');
    var cacheActive = rbCache.checked;
    console.log('using cache = ' + cacheActive);
    gridOptions.cacheQuickFilter = cacheActive;

    // set row data again, so to clear out any cache that might of existed
    gridOptions.api.setRowData(createRowData());
}



// setup the grid after the page has finished loading
document.addEventListener('DOMContentLoaded', function() {
    var gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.sizeColumnsToFit();
});