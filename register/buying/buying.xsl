<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <body>
                <h2>Shopping Catalog</h2>
                <table border="1">
                    <tr bgcolor="#18dfd3">
                        <th>Item Number</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Add</th>
                    </tr>
                    <xsl:for-each select="items/item">
                        <tr>
                            <td><xsl:value-of select="id" /></td>
                            <td><xsl:value-of select="name" /></td>
                            <td><xsl:value-of select="description" /></td>
                            <td><xsl:value-of select="price" /></td>
                            <td><xsl:value-of select="quantity" /></td>
                            <td><xsl:value-of select="add" /><button>Add one to cart</button></td>
                        </tr>
                    </xsl:for-each>
                </table>
                <br/>
                <br/>
                <h2>Shopping Cart</h2>
                <table border="1">
                    <tr bgcolor="#18dfd3">
                        <th>Item Number</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Remove</th>
                    </tr>
                    <xsl:for-each select="items/item">
                        <tr>
                            <td><xsl:value-of select="id" /></td>
                            <td><xsl:value-of select="price" /></td>
                            <td><xsl:value-of select="quantity" /></td>
                            <td><xsl:value-of select="add" /><button>Remove from cart</button></td>
                        </tr>
                    </xsl:for-each>
                    <tr><td>Total:</td><td id="total"></td></tr>
                    <tr><td><button>Confirm Purchase</button></td><td><button>Cancel Purchase</button></td></tr>
                </table>
                <script type="text/javascript" src="buying.js">&#160;</script>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>

